import { Router } from 'express';
import { login } from '../controllers/auth.controller';

const router = Router();

// Endpoint Login yang generate JWT token
router.post('/login', login);

export default router;
