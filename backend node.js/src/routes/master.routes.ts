import { Router } from 'express';
import { getShifts, getDepartments, getPositions } from '../controllers/master.controller';

const router = Router();

// Endpoints public / internal, bisa dikasih auth kalau perlu
router.get('/shifts', getShifts);
router.get('/departments', getDepartments);
router.get('/positions', getPositions);

export default router;
