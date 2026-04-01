-- CreateTable
CREATE TABLE `users` (
    `nrp` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'safety', 'csr', 'employee') NOT NULL,
    `is_active` BOOLEAN NOT NULL DEFAULT true,

    PRIMARY KEY (`nrp`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `mitra_kerja` (
    `mitra_kerja_id` INTEGER NOT NULL AUTO_INCREMENT,
    `mitra_kerja_name` VARCHAR(255) NOT NULL,
    `latitude` DECIMAL(10, 8) NULL,
    `longitude` DECIMAL(11, 8) NULL,
    `radius_meters` INTEGER NOT NULL DEFAULT 50,

    PRIMARY KEY (`mitra_kerja_id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `departments` (
    `dept_id` INTEGER NOT NULL AUTO_INCREMENT,
    `dept_name` VARCHAR(255) NOT NULL,

    PRIMARY KEY (`dept_id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `divisions` (
    `div_id` INTEGER NOT NULL AUTO_INCREMENT,
    `div_name` VARCHAR(255) NOT NULL,
    `dept_id` INTEGER NOT NULL,

    PRIMARY KEY (`div_id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `positions` (
    `pos_id` INTEGER NOT NULL AUTO_INCREMENT,
    `pos_name` VARCHAR(255) NOT NULL,

    PRIMARY KEY (`pos_id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `employees` (
    `nrp` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(255) NOT NULL,
    `pos_id` INTEGER NULL,
    `div_id` INTEGER NULL,
    `mitra_kerja_id` INTEGER NULL,
    `default_work_location` VARCHAR(255) NULL,

    PRIMARY KEY (`nrp`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `shifts` (
    `shift_id` INTEGER NOT NULL AUTO_INCREMENT,
    `shift_code` VARCHAR(255) NOT NULL,
    `time_in_expected` TIME NOT NULL,
    `time_out_expected` TIME NOT NULL,

    PRIMARY KEY (`shift_id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CreateTable
CREATE TABLE `attendances` (
    `att_id` VARCHAR(191) NOT NULL,
    `nrp` VARCHAR(255) NOT NULL,
    `attendance_date` DATE NOT NULL,
    `time_wita` TIME NOT NULL,
    `time_wib` TIME NOT NULL,
    `shift_id` INTEGER NOT NULL,
    `trans_type` ENUM('Check-in', 'Check-out', 'Izin', 'Sakit') NOT NULL,
    `cp_location` VARCHAR(255) NULL,
    `work_location` VARCHAR(255) NULL,
    `att_latitude` DECIMAL(10, 8) NULL,
    `att_longitude` DECIMAL(11, 8) NULL,
    `att_map_link` TEXT NULL,
    `photo_evidence` VARCHAR(255) NULL,
    `device_ip` VARCHAR(45) NULL,

    PRIMARY KEY (`att_id`)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- AddForeignKey
ALTER TABLE `divisions` ADD CONSTRAINT `divisions_dept_id_fkey` FOREIGN KEY (`dept_id`) REFERENCES `departments`(`dept_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `employees` ADD CONSTRAINT `employees_nrp_fkey` FOREIGN KEY (`nrp`) REFERENCES `users`(`nrp`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `employees` ADD CONSTRAINT `employees_pos_id_fkey` FOREIGN KEY (`pos_id`) REFERENCES `positions`(`pos_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `employees` ADD CONSTRAINT `employees_div_id_fkey` FOREIGN KEY (`div_id`) REFERENCES `divisions`(`div_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `employees` ADD CONSTRAINT `employees_mitra_kerja_id_fkey` FOREIGN KEY (`mitra_kerja_id`) REFERENCES `mitra_kerja`(`mitra_kerja_id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `attendances` ADD CONSTRAINT `attendances_nrp_fkey` FOREIGN KEY (`nrp`) REFERENCES `employees`(`nrp`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- AddForeignKey
ALTER TABLE `attendances` ADD CONSTRAINT `attendances_shift_id_fkey` FOREIGN KEY (`shift_id`) REFERENCES `shifts`(`shift_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

