import 'package:flutter/material.dart';

class EditProfileScreen extends StatelessWidget {
  final String initialUsername;
  final String initialBio;
  final TextEditingController usernameController;
  final TextEditingController bioController;
  final String profileImageUrl = 'assets/profile_picture.png'; // Replace with actual profile image

  EditProfileScreen({
    required this.initialUsername,
    required this.initialBio,
  })  : usernameController = TextEditingController(text: initialUsername),
        bioController = TextEditingController(text: initialBio);

  void saveProfile(BuildContext context) {
    // Return updated data to ProfileScreen
    Navigator.pop(context, {
      'username': usernameController.text,
      'bio': bioController.text,
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        title: Text(
          'Edit Profile',
          style: TextStyle(fontWeight: FontWeight.bold, color: Colors.white),
        ),
        backgroundColor: Colors.black,
        elevation: 0,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // Profile Image with Edit Button
            Stack(
              alignment: Alignment.center,
              children: [
                CircleAvatar(
                  radius: 60,
                  backgroundImage: AssetImage(profileImageUrl),
                ),
                Positioned(
                  bottom: 0,
                  right: 10,
                  child: IconButton(
                    icon: Icon(Icons.camera_alt, color: Colors.white),
                    onPressed: () {
                      // Code to change profile image
                    },
                  ),
                ),
              ],
            ),
            SizedBox(height: 20),

            // Username Field
            TextField(
              controller: usernameController,
              decoration: InputDecoration(
                labelText: 'Username',
                labelStyle: TextStyle(color: Colors.white),
                filled: true,
                fillColor: Colors.grey[850],
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8.0),
                  borderSide: BorderSide.none,
                ),
              ),
              style: TextStyle(color: Colors.white),
            ),
            SizedBox(height: 20),

            // Bio Field
            TextField(
              controller: bioController,
              maxLines: 3,
              decoration: InputDecoration(
                labelText: 'Bio',
                labelStyle: TextStyle(color: Colors.white),
                filled: true,
                fillColor: Colors.grey[850],
                border: OutlineInputBorder(
                  borderRadius: BorderRadius.circular(8.0),
                  borderSide: BorderSide.none,
                ),
              ),
              style: TextStyle(color: Colors.white),
            ),
            SizedBox(height: 30),

            // Save Button
            ElevatedButton(
              onPressed: () => saveProfile(context),
              child: Text('Save Changes'),
              style: ElevatedButton.styleFrom(
                primary: Colors.grey[800],
                padding: EdgeInsets.symmetric(horizontal: 40, vertical: 15),
                textStyle: TextStyle(fontSize: 16),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
