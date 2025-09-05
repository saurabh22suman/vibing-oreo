-- SQL seed for 10 dummy apps
BEGIN TRANSACTION;
INSERT INTO apps (title, description, image, link, category, created_at, updated_at) VALUES
('NoteNest', 'A cozy notes app for quick thoughts.', '/assets/images/placeholder.png', 'https://example.com/notenest', 'Utilities', datetime('now'), datetime('now')),
('FitPulse', 'Track workouts and metrics with a simple UI.', '/assets/images/placeholder.png', 'https://example.com/fitpulse', 'Health', datetime('now'), datetime('now')),
('BudgetBee', 'Personal budgeting made delightful.', '/assets/images/placeholder.png', 'https://example.com/budgetbee', 'Finance', datetime('now'), datetime('now')),
('PhotoFlick', 'A lightweight photo gallery with transitions.', '/assets/images/placeholder.png', 'https://example.com/photoflick', 'Photography', datetime('now'), datetime('now')),
('ShopLite', 'Minimal storefront demo for small sellers.', '/assets/images/placeholder.png', 'https://example.com/shoplite', 'E-commerce', datetime('now'), datetime('now')),
('TimeTide', 'A focused Pomodoro timer with themes.', '/assets/images/placeholder.png', 'https://example.com/timetide', 'Productivity', datetime('now'), datetime('now')),
('MapRoam', 'Simple map explorer for sightseeing.', '/assets/images/placeholder.png', 'https://example.com/maproam', 'Travel', datetime('now'), datetime('now')),
('CookPad', 'Save and share quick recipes.', '/assets/images/placeholder.png', 'https://example.com/cookpad', 'Food', datetime('now'), datetime('now')),
('Lingua', 'Micro language flashcards for daily practice.', '/assets/images/placeholder.png', 'https://example.com/lingua', 'Education', datetime('now'), datetime('now')),
('DevBoard', 'A compact dev dashboard showing metrics.', '/assets/images/placeholder.png', 'https://example.com/devboard', 'Developer', datetime('now'), datetime('now'));
COMMIT;
