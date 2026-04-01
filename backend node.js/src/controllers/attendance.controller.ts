import { Request, Response } from 'express';
import { prisma } from '../utils/db';
import { calculateDistance } from '../utils/geolocation';

export const checkIn = async (req: Request, res: Response): Promise<void> => {
  try {
    // Dipastikan telah melewati token auth
    const nrp = req.user!.nrp; 

    const { shift_id, cp_location, work_location, lat, long, photo_url } = req.body;

    if (!shift_id || lat === undefined || long === undefined) {
      res.status(400).json({ error: 'Data Shift, Latitude, dan Longitude wajib diisi.' });
      return;
    }

    // Melacak koordinat kantor dari Employee's Mitra Kerja
    const employeeData = await prisma.employees.findUnique({
      where: { nrp },
      include: { mitra_kerja: true }
    });

    if (employeeData?.mitra_kerja?.latitude && employeeData?.mitra_kerja?.longitude) {
      const officeLat = Number(employeeData.mitra_kerja.latitude);
      const officeLon = Number(employeeData.mitra_kerja.longitude);
      const radiusLimit = employeeData.mitra_kerja.radius_meters || 50;

      const distance = calculateDistance(lat, long, officeLat, officeLon);
      
      if (distance > radiusLimit) {
        res.status(403).json({ 
          error: 'Lokasi Anda berada di luar jangkauan area kerja terdaftar.', 
          jarak_meter: Math.round(distance),
          batas_radius_meter: radiusLimit
        });
        return;
      }
    }

    // Capture Local time 
    const now = new Date();

    const attendance = await prisma.attendances.create({
      data: {
        nrp,
        attendance_date: now,
        time_wita: now, // asumsi local time server adalah wita sesuai req
        time_wib: new Date(now.getTime() - 60 * 60 * 1000), // WIB is WITA - 1 hr
        shift_id,
        trans_type: 'Check_in',
        cp_location,
        work_location,
        att_latitude: lat,
        att_longitude: long,
        att_map_link: `https://maps.google.com/?q=${lat},${long}`,
        photo_evidence: photo_url
      }
    });

    res.status(201).json({
      message: 'Check-in berhasil disimpan!',
      data: attendance
    });

  } catch (error) {
    console.error('Check-in error:', error);
    res.status(500).json({ error: 'Gagal melakukan absensi.', details: String(error) });
  }
};

export const checkOut = async (req: Request, res: Response): Promise<void> => {
    try {
      const nrp = req.user!.nrp; 
      const { lat, long, photo_url } = req.body;
  
      // Opsional: Validasi kalau hari ini belum checkout dsb.
      // Dibuat route Create Transaksi ke-dua bernama Check-Out
      const now = new Date();
      // Untuk sederhananya kita asumsikan shift mengikuti jadwal checkin sebelumnya 
      // Atau aplikasi frontend yg kirim ulang id shift terhubung

      // Dummy pencarian shift hari ini
      const todayString = now.toISOString().split('T')[0];
      const todayCheckIn = await prisma.attendances.findFirst({
        where: {
            nrp,
            trans_type: 'Check_in',
            attendance_date: {
                gte: new Date(`${todayString}T00:00:00.000Z`)
            }
        },
        orderBy: { attendance_date: 'desc' }
      });

      if(!todayCheckIn) {
          res.status(404).json({ error: 'Anda belum Check-in hari ini!' });
          return;
      }

      const attendance = await prisma.attendances.create({
        data: {
          nrp,
          attendance_date: now,
          time_wita: now,
          time_wib: new Date(now.getTime() - 60 * 60 * 1000),
          shift_id: todayCheckIn.shift_id,
          trans_type: 'Check_out',
          att_latitude: lat,
          att_longitude: long,
          att_map_link: `https://maps.google.com/?q=${lat},${long}`,
          photo_evidence: photo_url
        }
      });
  
      res.status(201).json({
        message: 'Check-out berhasil disimpan!',
        data: attendance
      });
  
    } catch (error) {
      console.error('Check-out error:', error);
      res.status(500).json({ error: 'Gagal melakukan checkout absen.' });
    }
  };

  export const getMyAttendance = async (req: Request, res: Response): Promise<void> => {
    try {
        const nrp = req.user!.nrp;
        const records = await prisma.attendances.findMany({
            where: { nrp },
            orderBy: { attendance_date: 'desc' },
            include: { shift: true }
        });

        res.status(200).json(records);
    } catch(err) {
        res.status(500).json({ error: 'Gagal mengambil data.' });
    }
  }
