import { Router } from 'express';
import { login } from '../controllers/auth.controller';
import { validate } from '../middlewares/validation.middleware';
import { loginSchema } from '../utils/schemas';

const router = Router();

// Endpoint Login yang generate JWT token dengan validasi zOD
router.post('/login', validate(loginSchema), login);

export default router;
