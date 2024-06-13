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
        title: const Text('Formulario'),
        automaticallyImplyLeading: true,
      ),
      body: Padding(
        padding: EdgeInsets.all(MediaQuery.of(context).size.width * 0.02),
        child: ListView(
          children: <Widget>[
            const Text(
              '¡Realize el formulario por favor!',
              style: TextStyle(color: Colors.black, fontSize: 25),
            ),
            TextField(
              controller: _flightNumberController,
              style: const TextStyle(color: Colors.black, fontSize: 19),
              decoration: const InputDecoration(
                labelText: 'Número de vuelo',
                labelStyle: TextStyle(color: Colors.black, fontSize: 18),
                enabledBorder: UnderlineInputBorder(
                  borderSide: BorderSide(color: Colors.black),
                ),
                focusedBorder: UnderlineInputBorder(
                  borderSide: BorderSide(color: Colors.black),
                ),
              ),
            ),
            const SizedBox(height: 20),
            const Text('¿Usó el check-in en línea?', style: TextStyle(color: Colors.black, fontSize: 18)),
            Row(
              children: [
                Expanded(
                  child: RadioListTile<bool>(
                    title: const Text('Sí', style: TextStyle(color: Colors.black, fontSize: 20)),
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
                    title: const Text('No', style: TextStyle(color: Colors.black, fontSize: 20)),
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
              const Text('¿Cómo calificaría el proceso de check-in en línea?', style: TextStyle(color: Colors.black, fontSize: 18)),
              EmojiRating(key: _checkInRatingKey),
            ],
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría la puntualidad de su vuelo?', style: TextStyle(color: Colors.black, fontSize: 18)),
            EmojiRating(key: _punctualityRatingKey),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría el servicio a bordo?', style: TextStyle(color: Colors.black, fontSize: 18)),
            EmojiRating(key: _serviceRatingKey),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría su vuelo en general?', style: TextStyle(color: Colors.black, fontSize: 18)),
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
                  child: const Text('Entregar', style: TextStyle(fontSize: 20)),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
