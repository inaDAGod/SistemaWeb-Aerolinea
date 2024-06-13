import 'package:flutter/material.dart';

class EmojiRating extends StatefulWidget {
  const EmojiRating({Key? key}) : super(key: key);

  @override
  State<EmojiRating> createState() => EmojiRatingState();
}

class EmojiRatingState extends State<EmojiRating> {
  String? _selectedEmoji;

  bool hasSelected() {
    return _selectedEmoji != null;
  }

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: <Widget>[
        IconButton(
          icon: const Icon(Icons.sentiment_very_dissatisfied),
          color: _selectedEmoji == 'sad' ? Colors.red : Colors.white,
          onPressed: () {
            setState(() {
              _selectedEmoji = 'sad';
            });
          },
        ),
        IconButton(
          icon: const Icon(Icons.sentiment_neutral),
          color: _selectedEmoji == 'neutral' ? Colors.yellow : Colors.white,
          onPressed: () {
            setState(() {
              _selectedEmoji = 'neutral';
            });
          },
        ),
        IconButton(
          icon: const Icon(Icons.sentiment_very_satisfied),
          color: _selectedEmoji == 'happy' ? Colors.green : Colors.white,
          onPressed: () {
            setState(() {
              _selectedEmoji = 'happy';
            });
          },
        ),
      ],
    );
  }
}
