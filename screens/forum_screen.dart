import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:io';

class ForumScreen extends StatefulWidget {
  @override
  _ForumScreenState createState() => _ForumScreenState();
}

class _ForumScreenState extends State<ForumScreen> {
  List<Post> posts = [];
  final _formKey = GlobalKey<FormState>();
  String? _header;
  String? _content;
  XFile? _image;

  Future<void> _pickImage() async {
    final ImagePicker picker = ImagePicker();
    final XFile? pickedFile = await picker.pickImage(source: ImageSource.gallery);
    setState(() {
      _image = pickedFile;
    });
  }

  void _submitPost() {
    if (_formKey.currentState!.validate()) {
      setState(() {
        posts.add(Post(header: _header!, content: _content!, image: _image));
        _header = null;
        _content = null;
        _image = null;
      });
      _formKey.currentState!.reset();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(
          'Forum',
          style: TextStyle(fontWeight: FontWeight.bold, color: Colors.white),
        ),
        backgroundColor: Colors.black,
      ),
      backgroundColor: Colors.grey[900],
      body: SingleChildScrollView(
        child: Column(
          children: [
            Padding(
              padding: const EdgeInsets.all(16.0),
              child: ElevatedButton(
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.deepOrange,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12),
                  ),
                ),
                onPressed: () {
                  showModalBottomSheet(
                    context: context,
                    isScrollControlled: true,
                    builder: (context) {
                      return Container(
                        padding: const EdgeInsets.all(16.0),
                        decoration: BoxDecoration(
                          color: Colors.grey[850],
                          borderRadius: BorderRadius.vertical(top: Radius.circular(16)),
                        ),
                        child: SingleChildScrollView(
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              Text(
                                'Share Something!',
                                style: TextStyle(
                                  fontSize: 24,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                              SizedBox(height: 16),
                              Form(
                                key: _formKey,
                                child: Column(
                                  children: [
                                    TextFormField(
                                      decoration: InputDecoration(
                                        labelText: 'Header',
                                        labelStyle: TextStyle(color: Colors.white70),
                                        border: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(10),
                                          borderSide: BorderSide(color: Colors.white70),
                                        ),
                                      ),
                                      validator: (value) => value == null || value.isEmpty ? 'Please enter a header' : null,
                                      onChanged: (value) => _header = value,
                                    ),
                                    SizedBox(height: 16),
                                    TextFormField(
                                      maxLines: 4,
                                      decoration: InputDecoration(
                                        labelText: 'What\'s on your mind?',
                                        labelStyle: TextStyle(color: Colors.white70),
                                        border: OutlineInputBorder(
                                          borderRadius: BorderRadius.circular(10),
                                          borderSide: BorderSide(color: Colors.white70),
                                        ),
                                      ),
                                      validator: (value) => value == null || value.isEmpty ? 'Please enter some content' : null,
                                      onChanged: (value) => _content = value,
                                    ),
                                    SizedBox(height: 16),
                                    Row(
                                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                                      children: [
                                        ElevatedButton(
                                          onPressed: _pickImage,
                                          style: ElevatedButton.styleFrom(backgroundColor: Colors.deepOrange),
                                          child: Text('Attach Image'),
                                        ),
                                        if (_image != null) Text('Image selected', style: TextStyle(color: Colors.white70)),
                                      ],
                                    ),
                                    SizedBox(height: 16),
                                    ElevatedButton(
                                      onPressed: _submitPost,
                                      style: ElevatedButton.styleFrom(backgroundColor: Colors.deepOrange),
                                      child: Text('Post'),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                        ),
                      );
                    },
                  );
                },
                child: Text('Share Something!'),
              ),
            ),
            ListView.builder(
              shrinkWrap: true,
              physics: NeverScrollableScrollPhysics(),
              itemCount: posts.length,
              itemBuilder: (context, index) {
                final post = posts[index];
                return Card(
                  color: Colors.grey[800],
                  margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
                  child: Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          post.header,
                          style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: Colors.white),
                        ),
                        SizedBox(height: 8),
                        Text(post.content, style: TextStyle(color: Colors.white70)),
                        SizedBox(height: 8),
                        if (post.image != null)
                          ClipRRect(
                            borderRadius: BorderRadius.circular(8),
                            child: Image.file(
                              File(post.image!.path),
                              fit: BoxFit.cover,
                            ),
                          ),
                        SizedBox(height: 8),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Row(
                              children: [
                                IconButton(
                                  icon: Icon(Icons.thumb_up, color: Colors.white),
                                  onPressed: () => setState(() => post.likes++),
                                ),
                                Text('${post.likes}', style: TextStyle(color: Colors.white)),
                                SizedBox(width: 16),
                                IconButton(
                                  icon: Icon(Icons.thumb_down, color: Colors.white),
                                  onPressed: () => setState(() => post.dislikes++),
                                ),
                                Text('${post.dislikes}', style: TextStyle(color: Colors.white)),
                              ],
                            ),
                            IconButton(
                              icon: Icon(Icons.comment, color: Colors.white),
                              onPressed: () => _showCommentDialog(post),
                            ),
                          ],
                        ),
                        if (post.comments.isNotEmpty)
                          Column(
                            children: post.comments
                                .map((comment) => Padding(
                                      padding: const EdgeInsets.only(top: 8.0),
                                      child: Text(comment, style: TextStyle(fontStyle: FontStyle.italic, color: Colors.grey[300])),
                                    ))
                                .toList(),
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
    );
  }

  void _showCommentDialog(Post post) {
    final _commentController = TextEditingController();
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          backgroundColor: Colors.grey[800],
          title: Text('Add a Comment', style: TextStyle(color: Colors.white)),
          content: TextField(
            controller: _commentController,
            decoration: InputDecoration(hintText: 'Write your comment here...', hintStyle: TextStyle(color: Colors.white70)),
          ),
          actions: [
            TextButton(
              onPressed: () {
                setState(() => post.comments.add(_commentController.text));
                Navigator.of(context).pop();
              },
              child: Text('Submit', style: TextStyle(color: Colors.deepOrange)),
            ),
          ],
        );
      },
    );
  }
}

class Post {
  final String header;
  final String content;
  final XFile? image;
  int likes;
  int dislikes;
  List<String> comments;

  Post({required this.header, required this.content, this.image})
      : likes = 0,
        dislikes = 0,
        comments = [];
}
