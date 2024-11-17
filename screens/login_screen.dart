import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'registration_screen.dart';
import '/services/auth_service.dart';

// AuthService to handle API calls
class AuthService {
  // Replace with your actual login API endpoint URL
  static const String apiUrl = 'https://vista360.art/login.php';

  // Login function
  Future<Map<String, dynamic>> loginUser(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse(apiUrl),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({'email': email, 'password': password}),
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data; // Return the response data
      } else {
        throw Exception('Failed to login');
      }
    } catch (error) {
      return {'status': 'error', 'message': error.toString()};
    }
  }
}

class LoginScreen extends StatelessWidget {
  final TextEditingController emailController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  // Handle login button press
  void login(BuildContext context) async {
    String email = emailController.text;
    String password = passwordController.text;

    // Calling AuthService to log in the user
    final authService = AuthService();
    final response = await authService.loginUser(email, password);

    if (response['status'] == 'success') {
      // Handle successful login based on access level
      if (response['user_access'] == 'admin') {
        Navigator.pushReplacementNamed(context, '/admin_dashboard');
      } else {
        Navigator.pushReplacementNamed(context, '/home');
      }
    } else {
      // Show error if login fails
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(response['message'])),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black, // Set the background color to black
      appBar: AppBar(
        title: Text('Login'),
        backgroundColor: Colors.black, // Make app bar black
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            // Add the Vista logo here
            Image.asset(
              'assets/vista_logo.png', // Update this path if necessary
              height: 100, // Adjust the height as needed
            ),
            SizedBox(height: 20), // Spacing between logo and text fields
            TextField(
              controller: emailController,
              decoration: InputDecoration(
                labelText: 'Email',
                labelStyle: TextStyle(color: Colors.white), // Change label color
                enabledBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.white), // Border color
                ),
                focusedBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.blueAccent), // Focused border color
                ),
              ),
              style: TextStyle(color: Colors.white), // Change text color
            ),
            TextField(
              controller: passwordController,
              decoration: InputDecoration(
                labelText: 'Password',
                labelStyle: TextStyle(color: Colors.white), // Change label color
                enabledBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.white), // Border color
                ),
                focusedBorder: OutlineInputBorder(
                  borderSide: BorderSide(color: Colors.blueAccent), // Focused border color
                ),
                suffixIcon: IconButton(
                  onPressed: () {}, // Add functionality for password visibility toggle if needed
                  icon: Icon(Icons.remove_red_eye_sharp, color: Colors.white), // Change icon color
                ),
              ),
              obscureText: true,
              style: TextStyle(color: Colors.white), // Change text color
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () => login(context),
              child: Text('Login'),
              style: ElevatedButton.styleFrom(primary: Colors.blueAccent), // Button color
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                Text('Don\'t have an account?', style: TextStyle(color: Colors.white)), // Change text color
                TextButton(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => RegistrationScreen()),
                    );
                  },
                  child: Text('Register', style: TextStyle(color: Colors.blueAccent)), // Change text color
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
