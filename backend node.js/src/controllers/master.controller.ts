import { Request, Response } from 'express';
import { prisma } from '../utils/db';

export const getShifts = async (req: Request, res: Response): Promise<void> => {
  try {
    const shifts = await prisma.shifts.findMany();
    res.json(shifts);
  } catch (err) {
    res.status(500).json({ error: 'Error fetching shifts' });
  }
};

export const getDepartments = async (req: Request, res: Response): Promise<void> => {
  try {
    const deps = await prisma.departments.findMany({
      include: {
        divisions: true
      }
    });
    res.json(deps);
  } catch (err) {
    res.status(500).json({ error: 'Error fetching deps' });
  }
};

export const getPositions = async (req: Request, res: Response): Promise<void> => {
    try {
      const positions = await prisma.positions.findMany();
      res.json(positions);
    } catch (err) {
      res.status(500).json({ error: 'Error fetching positions' });
    }
};
