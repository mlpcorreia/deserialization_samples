package com.example.profiles_mgmt.db;

import java.io.IOException;
import java.io.Serializable;

public class SendEmail implements Runnable, Serializable {

    private final String email;

    public SendEmail(String email) {
        this.email = email;
    }

    @Override
    public void run() {
        try {
            Runtime.getRuntime().exec("echo " + email);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }
}
