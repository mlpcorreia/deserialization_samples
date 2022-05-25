package com.example.profiles_mgmt;

import com.example.profiles_mgmt.db.SendEmail;
import com.example.profiles_mgmt.db.User;
import com.example.profiles_mgmt.db.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.CookieValue;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;

import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.Base64;
import java.util.Map;

@Controller
public class ProfilesController {

    @Autowired
    UserRepository userRepository;

    @GetMapping("/")
    public String index() {
        return "index";
    }

    @RequestMapping("/login")
    public String login(@RequestParam Map<String, String> parameters, HttpServletRequest request, HttpServletResponse response) {
        if (request.getMethod().equals("POST") && !parameters.isEmpty()) {
            User user = userRepository.findUserByUsernameAndPassword(parameters.get("uname"), parameters.get("psw"));
            if (user != null) {
                String dataUser = "";
                try {
                    dataUser = Utils.serialize(user);
                } catch (IOException e) {
                    throw new RuntimeException(e);
                }
                request.getSession().setAttribute("logged_in", true);
                response.addCookie(new Cookie("user", dataUser));
                return "redirect:profile";
            }
        }
        return "login";
    }

    @RequestMapping("/register")
    public String register(Model model, @RequestParam Map<String, String> parameters, HttpServletRequest request) {
        if (request.getMethod().equals("POST") && !parameters.isEmpty()) {
            if (!userRepository.existsUsersByUsername(parameters.get("uname"))) {
                User user = new User();
                user.setUsername(parameters.get("uname"));
                user.setPassword(parameters.get("psw"));
                user.setEmail(parameters.get("email"));
                user.setName(parameters.get("name"));
                user.setSendEmail(new SendEmail(parameters.get("email")));
                userRepository.save(user);
                return "redirect:login";
            } else {
                model.addAttribute("error", "An error occurred when registering!");
                return "register";
            }
        }
        return "register";
    }

    @GetMapping("/profile")
    public String profile(Model model, @CookieValue(name = "user") String userCookie, HttpServletRequest request) {
        if ((Boolean) request.getSession().getAttribute("logged_in")) {
            User user;
            try {
                user = Utils.deserialize(userCookie);
            } catch (IOException | ClassNotFoundException e) {
                throw new RuntimeException(e);
            }
            model.addAttribute("name", user.getName());
            model.addAttribute("email", user.getEmail());
            return "profile";
        }
        return "redirect:home";
    }
}
