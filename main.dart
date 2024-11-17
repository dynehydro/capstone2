import 'package:flutter/material.dart';
import 'screens/login_screen.dart';
import 'screens/home_screen.dart';
import 'screens/registration_screen.dart';
import 'screens/auction_screen.dart';
import 'screens/profile_screen.dart';
import 'screens/forum_screen.dart';
import 'screens/galleries_screen.dart';

void main() {
  runApp(VistaApp());
}

class VistaApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Vista',
      theme: ThemeData(
        primarySwatch: Colors.grey,
        brightness: Brightness.dark, // Set dark theme
        appBarTheme: AppBarTheme(
          color: Colors.black,
          iconTheme: IconThemeData(color: Colors.white),
          titleTextStyle: TextStyle(color: Colors.white, fontSize: 20),
        ),
        bottomNavigationBarTheme: BottomNavigationBarThemeData(
          backgroundColor: Colors.black,
          selectedItemColor: Colors.white,
          unselectedItemColor: Colors.grey,
        ),
      ),
      initialRoute: '/login', // Set the starting screen to Login
      routes: {
        '/login': (context) => LoginScreen(),
        '/home': (context) => HomeScreen(),
        '/register': (context) => RegistrationScreen(),
        '/auction': (context) => AuctionScreen(), // Auction route
        '/profile': (context) => ProfileScreen(), // Profile route
        '/forum': (context) => ForumScreen(), // Forum route
      },
    );
  }
}
