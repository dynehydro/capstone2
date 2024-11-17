// TODO Implement this library.import 'dart:convert';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';

class AuthService {
  // Replace with your actual URL
  static const String apiUrl = 'https://vista360.art/main/login.php'; 

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
