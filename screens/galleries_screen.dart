import 'package:flutter/material.dart';
import '/gallery.dart'; // Import the Gallery model
import '/services/fetch_galleries.dart'; // Import the fetchGalleries function

class GalleriesScreen extends StatefulWidget {
  @override
  _GalleriesScreenState createState() => _GalleriesScreenState();
}

class _GalleriesScreenState extends State<GalleriesScreen> {
  late Future<List<Gallery>> galleries;

  @override
  void initState() {
    super.initState();
    galleries = fetchGalleries();  // Fetch galleries when the screen is initialized
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Available Galleries'),
      ),
      body: FutureBuilder<List<Gallery>>(
        future: galleries,  // Pass the future that loads galleries
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());  // Show loading indicator
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));  // Show error if any
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(child: Text('No galleries available'));  // Show message if no galleries
          }

          // Gallery data is available, build the list
          final galleryList = snapshot.data!;
          return ListView.builder(
            itemCount: galleryList.length,
            itemBuilder: (context, index) {
              final gallery = galleryList[index];
              return ListTile(
                title: Text(gallery.name),
                subtitle: Text(gallery.description),
                leading: Image.network(gallery.imageUrl),
                onTap: () {
                  // Navigate to the gallery details screen (optional)
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => GalleryDetailScreen(gallery: gallery)),
                  );
                },
              );
            },
          );
        },
      ),
    );
  }
}

class GalleryDetailScreen extends StatelessWidget {
  final Gallery gallery;

  GalleryDetailScreen({required this.gallery});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(gallery.name)),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Image.network(gallery.imageUrl),
            SizedBox(height: 16),
            Text(gallery.name, style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
            SizedBox(height: 8),
            Text(gallery.description),
          ],
        ),
      ),
    );
  }
}

