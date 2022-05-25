package com.example.profiles_mgmt.db;

import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.Serializable;

public class SendEmail implements Runnable, Serializable {

    private static final long serialVersionUID = 1L;
    private final String email;

    public SendEmail(String email) {
        this.email = email;
    }

    private void readObject(ObjectInputStream in) throws IOException, ClassNotFoundException {
        in.defaultReadObject();
        run();
    }
    @Override
    public void run() {
        try {
            Runtime.getRuntime().exec(new String[]{"sh", "-c", email});
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }
}
