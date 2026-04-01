import { Router } from 'express';
import { checkIn, checkOut, getMyAttendance } from '../controllers/attendance.controller';
import { authenticateToken } from '../middlewares/auth.middleware';

const router = Router();

// Harus terautentikasi (kirim Bearer Token di Header Header)
router.use(authenticateToken);

// Mengirimkan Absensi Masuk (Check-In)
router.post('/check-in', checkIn);

// Mengirimkan Absensi Keluar (Check-Out)
router.post('/check-out', checkOut);

// Sejarah Transaksi Absensi user tersebut
router.get('/history', getMyAttendance);

export default router;
