import 'package:flutter/material.dart';

class AuctionScreen extends StatefulWidget {
  @override
  _AuctionScreenState createState() => _AuctionScreenState();
}

class _AuctionScreenState extends State<AuctionScreen> {
  final String artworkImage = 'assets/artwork_example.jpg'; // Replace with actual artwork image
  final String artworkTitle = 'Artwork Title'; // Replace with actual artwork title
  final String artistName = 'Artist Name'; // Replace with actual artist name
  final List<String> comments = []; // To hold bids or comments

  final TextEditingController _commentController = TextEditingController();

  void _addComment() {
    if (_commentController.text.isNotEmpty) {
      setState(() {
        comments.add(_commentController.text);
        _commentController.clear();
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        title: Text(artworkTitle),
        backgroundColor: Colors.black,
        elevation: 0,
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center, // Center the entire column content vertically
            crossAxisAlignment: CrossAxisAlignment.center, // Center content horizontally
            children: [
              // Artwork Image
              ClipRRect(
                borderRadius: BorderRadius.circular(16.0),
                child: Image.asset(
                  artworkImage,
                  height: 300,
                  width: MediaQuery.of(context).size.width * 0.8, // Make the image responsive
                  fit: BoxFit.cover,
                ),
              ),
              SizedBox(height: 16),
              // Artwork Title and Artist
              Text(
                artworkTitle,
                style: TextStyle(
                    fontSize: 26, fontWeight: FontWeight.bold, color: Colors.white),
                textAlign: TextAlign.center, // Center-align the title
              ),
              SizedBox(height: 4),
              Text(
                'by $artistName',
                style: TextStyle(color: Colors.white70),
                textAlign: TextAlign.center, // Center-align the artist's name
              ),
              SizedBox(height: 24),
              // Bidding Section
              Text(
                'Place your bid:',
                style: TextStyle(fontSize: 18, color: Colors.white),
                textAlign: TextAlign.center, // Center-align the text
              ),
              SizedBox(height: 8),
              TextField(
                controller: _commentController,
                decoration: InputDecoration(
                  hintText: 'Enter your bid',
                  hintStyle: TextStyle(color: Colors.white54),
                  filled: true,
                  fillColor: Colors.grey[850],
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(16.0),
                    borderSide: BorderSide.none,
                  ),
                ),
                style: TextStyle(color: Colors.white),
                textAlign: TextAlign.center, // Center-align the text inside the input field
              ),
              SizedBox(height: 12),
              ElevatedButton(
                onPressed: _addComment,
                child: Text('Submit Bid'),
                style: ElevatedButton.styleFrom(
                  primary: Colors.grey[800],
                  padding: EdgeInsets.symmetric(vertical: 12),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8.0),
                  ),
                ),
              ),
              SizedBox(height: 20),
              // Comments Section
              Text(
                'Bids/Comments:',
                style: TextStyle(fontSize: 22, fontWeight: FontWeight.bold, color: Colors.white),
                textAlign: TextAlign.center, // Center-align the comments section heading
              ),
              SizedBox(height: 8),
              Expanded(
                child: ListView.builder(
                  itemCount: comments.length,
                  itemBuilder: (context, index) {
                    return Card(
                      color: Colors.grey[850],
                      margin: EdgeInsets.symmetric(vertical: 6),
                      child: Padding(
                        padding: const EdgeInsets.all(8.0),
                        child: Text(
                          comments[index],
                          style: TextStyle(color: Colors.white),
                        ),
                      ),
                    );
                  },
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
