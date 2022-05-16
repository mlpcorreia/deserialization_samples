package com.example.profiles_mgmt;

import com.example.profiles_mgmt.db.User;

import java.io.*;
import java.util.Base64;

public class Utils {

    public static String serialize(User user) throws IOException {
        final ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
        final ObjectOutputStream objectOutputStream = new ObjectOutputStream(byteArrayOutputStream);
        objectOutputStream.writeObject(user);
        objectOutputStream.close();
        return Base64.getEncoder().encodeToString(byteArrayOutputStream.toByteArray());
    }

    public static User deserialize(String data) throws IOException, ClassNotFoundException {
        byte[] dataBytes = Base64.getDecoder().decode(data);
        final ByteArrayInputStream byteArrayInputStream = new ByteArrayInputStream(dataBytes);
        final ObjectInputStream objectInputStream = new ObjectInputStream(byteArrayInputStream);
        final User user = (User) objectInputStream.readObject();
        objectInputStream.close();
        return user;
    }
}
