/**
 * Menghitung jarak antara dua titik koordinat bumi (Latitude & Longitude) dalam satuan Meter.
 * Memakai formula Haversine untuk mendapatkan jarak akurat membelah rotasi bumi.
 * 
 * @param lat1 Latitude Pengguna
 * @param lon1 Longitude Pengguna
 * @param lat2 Latitude Pusat (Kantor)
 * @param lon2 Longitude Pusat (Kantor)
 * @returns Jarak dalam bentuk Meter
 */
export const calculateDistance = (lat1: number, lon1: number, lat2: number, lon2: number): number => {
    const R = 6371e3; // Radius bumi dalam meter
    const phi1 = lat1 * Math.PI / 180; // konversi ke radians
    const phi2 = lat2 * Math.PI / 180;
    const deltaPhi = (lat2 - lat1) * Math.PI / 180;
    const deltaLambda = (lon2 - lon1) * Math.PI / 180;

    const a = Math.sin(deltaPhi / 2) * Math.sin(deltaPhi / 2) +
        Math.cos(phi1) * Math.cos(phi2) *
        Math.sin(deltaLambda / 2) * Math.sin(deltaLambda / 2);
        
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    const distance = R * c; 
    return distance; // Jarak aktual di bumi
};
