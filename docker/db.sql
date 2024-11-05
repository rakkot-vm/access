#
# something like migrations :)
#


CREATE DATABASE IF NOT EXISTS access_control;
USE access_control;

CREATE TABLE `groups` (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        group_name VARCHAR(50) UNIQUE NOT NULL
);

-- Users - can(and should) belong to one group, have unique username
CREATE TABLE users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       username VARCHAR(50) UNIQUE NOT NULL,
                       group_id INT NOT NULL,
                       FOREIGN KEY (group_id) REFERENCES `groups`(id)
);

CREATE TABLE modules (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         module_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE functions (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           function_name VARCHAR(50) UNIQUE NOT NULL,
                           module_id INT NOT NULL,
                           FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

CREATE TABLE group_module_access (
                                     group_id INT,
                                     module_id INT,
                                     PRIMARY KEY (group_id, module_id),
                                     FOREIGN KEY (group_id) REFERENCES `groups`(id) ON DELETE CASCADE,
                                     FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

CREATE TABLE group_function_access (
                                       group_id INT,
                                       function_id INT,
                                       PRIMARY KEY (group_id, function_id),
                                       FOREIGN KEY (group_id) REFERENCES `groups`(id) ON DELETE CASCADE,
                                       FOREIGN KEY (function_id) REFERENCES functions(id) ON DELETE CASCADE
);

CREATE TABLE user_module_access (
                                    user_id INT,
                                    module_id INT,
                                    PRIMARY KEY (user_id, module_id),
                                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                                    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

CREATE TABLE user_function_access (
                                      user_id INT,
                                      function_id INT,
                                      PRIMARY KEY (user_id, function_id),
                                      FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                                      FOREIGN KEY (function_id) REFERENCES functions(id) ON DELETE CASCADE
);

# -------------------------
# seed - just for testing, default data accords to description
# (in real project would be great to have place with seeds files or using tests)
# -------------------------


INSERT INTO `groups` (group_name) VALUES ('Group 1');


INSERT INTO users (username, group_id) VALUES ('User 1', 1), ('User 2', 1);


INSERT INTO modules (module_name) VALUES ('Module 1');


INSERT INTO functions (function_name, module_id) VALUES ('Function 1', 1), ('Function 2', 1);


INSERT INTO group_module_access (group_id, module_id) VALUES (1, 1);

# ------

INSERT INTO `groups` (group_name) VALUES ('Group 2');

INSERT INTO modules (module_name) VALUES ('Module 2');

INSERT INTO functions (function_name, module_id) VALUES ('Function 3', 2), ('Function 4', 2);

INSERT INTO group_function_access (group_id, function_id) VALUES (2, 4);

INSERT INTO users (username, group_id) VALUES ('User 3', 2), ('User 4', 2);

INSERT INTO user_module_access (user_id, module_id) VALUES (4, 2);