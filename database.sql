-- Database schema for Blog Management System
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS blogs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  short_description TEXT NOT NULL,
  content TEXT NOT NULL,
  category VARCHAR(100) NOT NULL,
  image VARCHAR(255) DEFAULT NULL,
  date DATE NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins (username, password) VALUES
('admin', '$2y$10$0KpFjLf8GZ3LRQWvMnYvbeJHI9mYaYbDmumk55ZlfL1NT2BslmE9G');

INSERT INTO blogs (title, short_description, content, category, image, date) VALUES
('How to Prepare for Admit Card', 'A complete guide to admit card release and verification steps.', 'This article explains how to download and verify your admit card. Follow each step carefully and keep your documents ready.', 'Admit Card', 'https://via.placeholder.com/900x500?text=Admit+Card', '2026-05-01'),
('Exam Result Announcement', 'Check the latest exam results and score validation tips.', 'Results are declared for the recent exam cycle. Learn how to download the mark sheet and check for corrections.', 'Result', 'https://via.placeholder.com/900x500?text=Result', '2026-04-23'),
('Top Study Strategies', 'Effective study strategies for exam success and time management.', 'Discover study plans, revision techniques, and schedule ideas to boost your results and stay motivated.', 'Study', 'https://via.placeholder.com/900x500?text=Study', '2026-04-15');
