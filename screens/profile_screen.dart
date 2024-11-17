import 'package:flutter/material.dart';
import 'package:vista_mobile_capstone/screens/edit_profile_screen.dart';


class ProfileScreen extends StatefulWidget {
  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  String username = "YourUsername"; // Replace with dynamic data
  String bio = "This is a sample bio for your profile. Feel free to customize it!";
  final String profileImageUrl = 'assets/profile_picture.png'; // Replace with actual image asset
  final List<String> userPosts = [
    'assets/post1.jpg', // Replace with actual post images
    'assets/post2.jpg',
    'assets/post3.jpg',
    'assets/post4.jpg',
    'assets/post5.jpg',
  ];

  void _navigateToEditProfile() async {
    // Wait for the returned result from EditProfileScreen
    final updatedProfile = await Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => EditProfileScreen(
          initialUsername: username,
          initialBio: bio,
        ),
      ),
    );

    // If there are changes, update the profile data
    if (updatedProfile != null) {
      setState(() {
        username = updatedProfile['username'];
        bio = updatedProfile['bio'];
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Profile Picture and Info
              Row(
                children: [
                  CircleAvatar(
                    radius: 40,
                    backgroundImage: AssetImage(profileImageUrl),
                  ),
                  SizedBox(width: 16),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        username,
                        style: TextStyle(fontSize: 24, color: Colors.white),
                      ),
                      SizedBox(height: 4),
                      Text(
                        bio,
                        style: TextStyle(color: Colors.white70),
                      ),
                    ],
                  ),
                ],
              ),
              SizedBox(height: 20),
              // Action Buttons
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  ElevatedButton(
                    onPressed: _navigateToEditProfile,
                    child: Text('Edit Profile'),
                    style: ElevatedButton.styleFrom(primary: Colors.grey[800]),
                  ),
                  ElevatedButton(
                    onPressed: () {
                      // Implement follow/unfollow logic
                    },
                    child: Text('Follow'),
                    style: ElevatedButton.styleFrom(primary: Colors.grey[800]),
                  ),
                ],
              ),
              SizedBox(height: 20),
              // User Posts
              Text(
                'Posts',
                style: TextStyle(fontSize: 24, color: Colors.white),
              ),
              SizedBox(height: 10),
              GridView.builder(
                physics: NeverScrollableScrollPhysics(),
                shrinkWrap: true,
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 3,
                  childAspectRatio: 1,
                  crossAxisSpacing: 4,
                  mainAxisSpacing: 4,
                ),
                itemCount: userPosts.length,
                itemBuilder: (context, index) {
                  return ClipRRect(
                    borderRadius: BorderRadius.circular(8.0),
                    child: Image.asset(
                      userPosts[index],
                      fit: BoxFit.cover,
                    ),
                  );
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}
