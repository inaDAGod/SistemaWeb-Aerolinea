import 'package:flutter/material.dart';

class SatisForm extends StatelessWidget {
  const SatisForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Formulario de Evaluación de Vuelo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSwatch(primarySwatch: Colors.deepPurple),
        // Ajusta el tema según tus preferencias
      ),
      home: const MyHomePage(title: 'Evaluación de Vuelo'),
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({Key? key, required this.title}) : super(key: key);

  final String title;

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
      ),
      body: Center(
        child: ElevatedButton(
          onPressed: () {
            Navigator.push(
              context,
              MaterialPageRoute(builder: (context) => TaskListScreen()),
            );
          },
          child: const Text('Ir a la Formulario'),
        ),
      ),
    );
  }
}

class TaskListScreen extends StatefulWidget {
  @override
  _TaskListScreenState createState() => _TaskListScreenState();
}

class _TaskListScreenState extends State<TaskListScreen> {
  bool _checkedInOnline = false;
  final TextEditingController _flightNumberController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Lista de Tareas'),
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
              const EmojiRating(),
            ],
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría la puntualidad de su vuelo?'),
            const EmojiRating(),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría el servicio a bordo?'),
            const EmojiRating(),
            const SizedBox(height: 20),
            const Text('¿Cómo calificaría su vuelo en general?'),
            const EmojiRating(),
            const SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(builder: (context) => const ConfirmationPage()),
                );
              },
              child: const Text('Submit'),
            ),
          ],
        ),
      ),
    );
  }
}

class EmojiRating extends StatefulWidget {
  const EmojiRating({Key? key}) : super(key: key);

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

class ConfirmationPage extends StatelessWidget {
  const ConfirmationPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Formulario Realizado'),
      ),
      body: Center(
        child: Text(
          '¡Gracias por enviar el formulario!',
          style: const TextStyle(fontSize: 24),
        ),
      ),
    );
  }
}
