import 'dart:convert';
import 'dart:async';
import 'package:flutter/material.dart';
import 'artwork_details_screen.dart'; // Import the new details screen
import 'package:http/http.dart' as http; // Import for HTTP requests

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final List<String> images = [
    'assets/orangeproject.jpg',
    'assets/interaction.jpg',
    'assets/360.jpg',
  ];

  int currentIndex = 0;
  List<Map<String, dynamic>> galleries = [];

  @override
  void initState() {
    super.initState();
    _fetchGalleries(); // Fetch galleries on initialization

    // Timer to change the image every 3 seconds
    Timer.periodic(Duration(seconds: 3), (Timer timer) {
      setState(() {
        currentIndex = (currentIndex + 1) % images.length;
      });
    });
  }

  Future<void> _fetchGalleries() async {
    final url = 'https://yourbackendurl.com/getGalleries.php'; // Replace with your backend URL

    try {
      final response = await http.get(Uri.parse(url));
      
      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        setState(() {
          galleries = List<Map<String, dynamic>>.from(data);
        });
      } else {
        print('Failed to load galleries');
      }
    } catch (e) {
      print('Error fetching galleries: $e');
    }
  }

  void _onBottomNavTapped(int index) {
    switch (index) {
      case 0:
        // Stay on Home screen
        break;
      case 1:
        Navigator.of(context).pushNamed('/auction'); // Navigate to Auction screen
        break;
      case 2:
        Navigator.of(context).pushNamed('/forum'); // Navigate to Forum screen
        break;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          'Welcome to Vista',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        backgroundColor: Colors.black,
        actions: [
          PopupMenuButton<String>(
            icon: Icon(Icons.more_vert, color: Colors.white),
            onSelected: (value) {
              if (value == 'profile') {
                Navigator.of(context).pushNamed('/profile');
              } else if (value == 'logout') {
                Navigator.of(context).pushReplacementNamed('/login');
              }
            },
            itemBuilder: (BuildContext context) {
              return [
                PopupMenuItem<String>(
                  enabled: false,
                  child: Column(
                    children: [
                      CircleAvatar(
                        radius: 30,
                        backgroundImage: AssetImage('assets/profile.jpg'),
                      ),
                      SizedBox(height: 8),
                    ],
                  ),
                ),
                PopupMenuItem<String>(
                  value: 'profile',
                  child: Text('Profile', style: TextStyle(color: Color.fromARGB(255, 255, 255, 255))),
                ),
                PopupMenuItem<String>(
                  value: 'logout',
                  child: Text('Logout', style: TextStyle(color: const Color.fromARGB(255, 255, 255, 255))),
                ),
              ];
            },
          ),
        ],
      ),
      body: SingleChildScrollView(
        child: Column(
          children: [
            // Image Carousel
            Container(
              height: 200,
              child: PageView.builder(
                itemCount: images.length,
                controller: PageController(initialPage: currentIndex),
                itemBuilder: (context, index) {
                  return ClipRRect(
                    borderRadius: BorderRadius.circular(10),
                    child: Image.asset(
                      images[index],
                      fit: BoxFit.cover,
                    ),
                  );
                },
              ),
            ),
            Container(
              padding: const EdgeInsets.all(16.0),
              color: Colors.grey[850],
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Galleries',
                    style: TextStyle(fontSize: 24, color: Colors.white, fontWeight: FontWeight.bold),
                  ),
                  SizedBox(height: 8),
                  Text(
                    'Explore a diverse collection of galleries. Connect with the community and discover new artworks.',
                    style: TextStyle(color: Colors.white70),
                  ),
                  SizedBox(height: 16),
                  ElevatedButton(
                    onPressed: () {}, // Navigate to galleries or other screen if needed
                    style: ElevatedButton.styleFrom(
                      primary: Colors.deepOrange,
                      onPrimary: Colors.white,
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
                      padding: EdgeInsets.symmetric(vertical: 15, horizontal: 30),
                    ),
                    child: Text('Browse Artworks'),
                  ),
                ],
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(8.0),
              child: Text(
                'Featured Galleries',
                style: TextStyle(fontSize: 24, color: Colors.white),
              ),
            ),
            // Gallery List
            ListView.builder(
              shrinkWrap: true,
              physics: NeverScrollableScrollPhysics(),
              itemCount: galleries.length,
              itemBuilder: (context, index) {
                final gallery = galleries[index];
                return GestureDetector(
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => ArtworkDetailsScreen(
                          image: gallery['image'], // Dynamically loaded image
                          title: gallery['title'], // Dynamically loaded title
                          artist: gallery['artist'], // Dynamically loaded artist
                          gallery: gallery['gallery_name'], // Dynamically loaded gallery name
                          contactNumber: gallery['contact'], // Dynamically loaded contact number
                          description: gallery['description'], // Dynamically loaded description
                        ),
                      ),
                    );
                  },
                  child: Card(
                    color: Colors.grey[850],
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
                    elevation: 5,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Expanded(
                          child: ClipRRect(
                            borderRadius: BorderRadius.vertical(top: Radius.circular(15)),
                            child: Image.network(
                              gallery['image'], // Dynamically loaded image URL
                              fit: BoxFit.cover,
                            ),
                          ),
                        ),
                        Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: Text(
                            gallery['title'], // Dynamically loaded title
                            style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                          ),
                        ),
                        Padding(
                          padding: const EdgeInsets.only(left: 8.0),
                          child: Text(
                            gallery['artist'], // Dynamically loaded artist name
                            style: TextStyle(color: Colors.white70),
                          ),
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
          ],
        ),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () {},
        backgroundColor: Colors.grey[800],
        child: Icon(Icons.add),
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.art_track),
            label: 'Auction',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.forum),
            label: 'Forum',
          ),
        ],
        currentIndex: 0,
        backgroundColor: Colors.black,
        selectedItemColor: Colors.white,
        unselectedItemColor: Colors.grey,
        onTap: _onBottomNavTapped,
      ),
    );
  }
}
