-- Created By: Patrick Dean
--       Date: 04/03/15
-- -------------------------------------------------------------------------------------------------------------
-- View Creation script
-- -------------------------------------------------------------------------------------------------------------
-- View all categories

CREATE VIEW view_categories
AS
   SELECT category_id, category_name FROM categories;

-- View all Users

CREATE VIEW view_users
AS
   SELECT user_id,
          user_first_name,
          user_last_name,
          user_email,
          user_password,
          user_photo,
          user_work_phone,
          user_personal_phone,
          user_bio,
          created_timestamp,
          updated_timestamp
     FROM users;

-- View all Products

CREATE VIEW view_product_master
AS
   SELECT p.product_id,
          p.user_id,
          u.user_first_name,
          u.user_last_name,
          u.user_email,
          u.user_work_phone,
          u.user_personal_phone,
          p.product_name,
          p.category_id,
          c.category_name,
          p.product_descr,
          p.product_price,
          p.negotiate_fg,
          p.product_photo,
          p.created_timestamp,
          p.updated_timestamp
     FROM categories AS c
          RIGHT JOIN products AS p ON c.category_id = p.category_id
          RIGHT JOIN users AS u ON p.user_id = u.user_id;