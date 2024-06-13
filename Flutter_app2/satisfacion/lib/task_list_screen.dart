import 'package:flutter/material.dart';
import 'confirmation_page.dart';
import 'emoji_rating.dart';

class TaskListScreen extends StatefulWidget {
  @override
  _TaskListScreenState createState() => _TaskListScreenState();
}

class _TaskListScreenState extends State<TaskListScreen> {
  bool _checkedInOnline = false;
  final TextEditingController _flightNumberController = TextEditingController();

  final GlobalKey<EmojiRatingState> _checkInRatingKey = GlobalKey<EmojiRatingState>();
  final GlobalKey<EmojiRatingState> _punctualityRatingKey = GlobalKey<EmojiRatingState>();
  final GlobalKey<EmojiRatingState> _serviceRatingKey = GlobalKey<EmojiRatingState>();
  final GlobalKey<EmojiRatingState> _overallRatingKey = GlobalKey<EmojiRatingState>();

  bool _isFormValid() {
    if (_flightNumberController.text.isEmpty) {
      return false;
    }

    if (_checkedInOnline == null) {
      return false;
    }

    if (_checkedInOnline == true && !_checkInRatingKey.currentState!.hasSelected()) {
      return false;
    }

    if (!_punctualityRatingKey.currentState!.hasSelected()) {
      return false;
    }

    if (!_serviceRatingKey.currentState!.hasSelected()) {
      return false;
    }

    if (!_overallRatingKey.currentState!.hasSelected()) {
      return false;
    }

    return true;
  }

  void _showValidationError() {
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Text('Llene todo los campos por favor'),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Row(
          children: [
            Image.asset(
              'images/logoavion.png',
              height: 80,
            ),
            const SizedBox(width: 30),
            const Text('', style: TextStyle(color: Colors.white)),
          ],
        ),
        automaticallyImplyLeading: false,
      ),
      body: Padding(
        padding: EdgeInsets.all(MediaQuery.of(context).size.width * 0.02),
        child: ListView(
          children: <Widget>[
            const Text(
              '¡Realize el formulario por favor!',
              style: TextStyle(color: Colors.white, fontSize: 25), // Increase font size
            ),
            TextField(
              controller: _flightNumberController,
              style: const TextStyle(color: Colors.white, fontSize: 19), // Increase font size
              decoration: InputDecoration(
                labelText: 'Número de vuelo',
                labelStyle: const TextStyle(color: Colors.white, fontSize: 18),
                enabledBorder: const UnderlineInputBorder(
                  borderSide: BorderSide(color: Colors.white),
                ),
                focusedBorder: const UnderlineInputBorder(
                  borderSide: BorderSide(color: Colors.white),
                ),
              ),
            ),
            const SizedBox(height: 20),
            const Text('¿Usó el check-in en línea?', style: TextStyle(color: Colors.white, fontSize: 18)), // Increase font size
            Row(
              children: [
                Expanded(
                  child: RadioListTile<bool>(
                    title: const Text('Sí', style: TextStyle(color: Colors.white, fontSize: 20)), // Increase font size
                    value: true,
                    groupValue: _checkedInOnline,
                    onChanged: (value) {
                      setState(() {
                        _checkedInOnline = value!;
                      });
                    },
                  ),
                ),
                Expanded(
                  child: RadioListTile<bool>(
                    title: const Text('No', style: TextStyle(color: Colors.white, fontSize: 20)), // Increase font size
                    value: false,
                    groupValue: _checkedInOnline,
                    onChanged: (value) {
                      setState(() {
                        _checkedInOnline = value!;
                      });
                    },
                  ),
                ),
              ],
            ),
            if (_checkedInOnline) ...[
              const SizedBox(height: 20),
              const Text('¿Cómo calificaría el proceso de check-in en línea?', style: TextStyle(color: Colors.white, fontSize: 18)), // Increase font size
              EmojiRating(key: _checkInRatingKey),
            ],
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría la puntualidad de su vuelo?', style: TextStyle(color: Colors.white, fontSize: 18)), // Increase font size
            EmojiRating(key: _punctualityRatingKey),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría el servicio a bordo?', style: TextStyle(color: Colors.white, fontSize: 18)), // Increase font size
            EmojiRating(key: _serviceRatingKey),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría su vuelo en general?', style: TextStyle(color: Colors.white, fontSize: 18)), // Increase font size
            EmojiRating(key: _overallRatingKey),
            const SizedBox(height: 20),
            Center(
              child: FractionallySizedBox(
                widthFactor: 0.4,
                child: ElevatedButton(
                  onPressed: () {
                    if (_isFormValid()) {
                      Navigator.pushReplacement(
                        context,
                        MaterialPageRoute(builder: (context) => const ConfirmationPage()),
                      );
                    } else {
                      _showValidationError();
                    }
                  },
                  child: const Text('Submit', style: TextStyle(fontSize: 20)), // Increase font size
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
