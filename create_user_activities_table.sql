-- Run this SQL in PostgreSQL if php artisan migrate fails
-- Creates the user_activities table

CREATE TABLE IF NOT EXISTS user_activities (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    activity_date DATE NOT NULL,
    description TEXT NOT NULL,
    title VARCHAR(255) NULL,
    rating INTEGER NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT user_activities_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS user_activities_user_id_index ON user_activities(user_id);
CREATE INDEX IF NOT EXISTS user_activities_activity_date_index ON user_activities(activity_date);
