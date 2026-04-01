import express from 'express';
import cors from 'cors';

// Import Routes
import authRoutes from './routes/auth.routes';
import attendanceRoutes from './routes/attendance.routes';
import masterRoutes from './routes/master.routes';

const app = express();

// Middleware dasar
app.use(cors()); // Allow Origin Flutter/Web
app.use(express.json()); // Allow Parsing JSON
app.use(express.urlencoded({ extended: true }));

// Rute Basic Cek Server
app.get('/', (req, res) => {
  res.send('API Backend Absensi Berjalan Lancar!');
});

// Pendaftaran Global Rooutes
app.use('/api/auth', authRoutes);
app.use('/api/attendance', attendanceRoutes);
app.use('/api/master', masterRoutes);

// Penanganan Route NotFound
app.use((req, res, next) => {
  res.status(404).json({ error: 'Endpoint tidak ditemukan' });
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`🚀 Server API berjalan di http://localhost:${PORT}`);
});
