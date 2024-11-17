class Gallery {
  final String name;
  final String description;
  final String imageUrl;

  Gallery({
    required this.name,
    required this.description,
    required this.imageUrl,
  });

  // Factory constructor to create a Gallery from JSON
  factory Gallery.fromJson(Map<String, dynamic> json) {
    return Gallery(
      name: json['name'],  // Adjusted based on your column names
      description: json['description'],
      imageUrl: json['imageUrl'],
    );
  }
}
