import 'dart:convert';
import 'package:http/http.dart' as http;
import '/gallery.dart'; // Import the Gallery model

Future<List<Gallery>> fetchGalleries() async {
  // Replace with your web app URL for the galleries API
  final response = await http.get(Uri.parse('https://your-web-app-url.com/get-galleries.php'));

  if (response.statusCode == 200) {
    // If the server returns a successful response (200), parse the JSON
    List<dynamic> data = json.decode(response.body);
    return data.map((json) => Gallery.fromJson(json)).toList();
  } else {
    // If the response is not 200, throw an error
    throw Exception('Failed to load galleries');
  }
}
