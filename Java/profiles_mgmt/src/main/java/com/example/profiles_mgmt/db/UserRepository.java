package com.example.profiles_mgmt.db;

import org.springframework.data.jpa.repository.JpaRepository;

public interface UserRepository extends JpaRepository<User, Long> {
    User findUserByUsernameAndPassword(String username, String password);
    boolean existsUsersByUsername(String username);
}
