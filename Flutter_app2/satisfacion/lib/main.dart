import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Formulario de Evaluación de Vuelo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: const MyHomePage(title: 'Evaluación de Vuelo'),
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key, required this.title});

  final String title;

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  bool _checkedInOnline = false;
  final TextEditingController _flightNumberController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Theme.of(context).colorScheme.inversePrimary,
        title: Text(widget.title),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: ListView(
          children: <Widget>[
            TextField(
              controller: _flightNumberController,
              decoration: const InputDecoration(
                labelText: 'Número de vuelo',
              ),
            ),
            const SizedBox(height: 20),
            const Text('¿Usó el check-in en línea?'),
            Row(
              children: [
                Expanded(
                  child: RadioListTile<bool>(
                    title: const Text('Sí'),
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
                    title: const Text('No'),
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
              const Text('¿Cómo calificaría el proceso de check-in en línea?'),
              EmojiRating(),
            ],
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría la puntualidad de su vuelo?'),
            EmojiRating(),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría el servicio a bordo?'),
            EmojiRating(),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría su vuelo en general?'),
            EmojiRating(),
          ],
        ),
      ),
    );
  }
}

class EmojiRating extends StatefulWidget {
  const EmojiRating({super.key});

  @override
  State<EmojiRating> createState() => _EmojiRatingState();
}

class _EmojiRatingState extends State<EmojiRating> {
  String? _selectedEmoji;

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: <Widget>[
        IconButton(
          icon: const Icon(Icons.sentiment_very_dissatisfied),
          color: _selectedEmoji == 'sad' ? Colors.red : Colors.grey,
          onPressed: () {
            setState(() {
              _selectedEmoji = 'sad';
            });
          },
        ),
        IconButton(
          icon: const Icon(Icons.sentiment_neutral),
          color: _selectedEmoji == 'neutral' ? Colors.yellow : Colors.grey,
          onPressed: () {
            setState(() {
              _selectedEmoji = 'neutral';
            });
          },
        ),
        IconButton(
          icon: const Icon(Icons.sentiment_very_satisfied),
          color: _selectedEmoji == 'happy' ? Colors.green : Colors.grey,
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
