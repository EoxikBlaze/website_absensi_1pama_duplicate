import { PrismaClient } from '@prisma/client';
import bcrypt from 'bcrypt';

const prisma = new PrismaClient();

async function main() {
  const nrp_username = 'adminPama';
  const plainPassword = 'isnabatuampar';
  
  // Enkripsi kata sandi menggunakan bcrypt
  const hashedPassword = await bcrypt.hash(plainPassword, 10);

  // Upsert akan membuat data kalau belum ada, update kalau sudah ada
  const adminUser = await prisma.users.upsert({
    where: { nrp: nrp_username },
    update: { 
      password_hash: hashedPassword, 
      role: 'admin', 
      is_active: true 
    },
    create: {
      nrp: nrp_username,
      password_hash: hashedPassword,
      role: 'admin',
      is_active: true,
    }
  });

  console.log(`✅ Administrator default berhasil ditanamkan: ${adminUser.nrp}`);
}

main()
  .catch((e) => {
    console.error('Terjadi kesalahan saat melakukan seeding:', e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
