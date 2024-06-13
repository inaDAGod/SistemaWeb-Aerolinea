import 'package:flutter/material.dart';
import 'task_list_screen.dart';

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
        title: Row(
          children: [
            Image.asset(
              'images/logoavion.png',
              height: 80,
            ),
            const SizedBox(width: 30),
            Text(widget.title),
          ],
        ),
      ),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.end, // Aligns button to the right
          children: [
            ElevatedButton(
              onPressed: () {
                Navigator.pushReplacement(
                  context,
                  MaterialPageRoute(builder: (context) => TaskListScreen()),
                );
              },
              child: const Text('Ir a la Formulario', style: TextStyle(fontSize: 25)),
            ),
            const SizedBox(height: 16),
            Expanded(
              child: Column(
                children: [
                  Expanded(
                    child: FractionallySizedBox(
                      widthFactor: 0.8, // Cover 80% of the screen width
                      heightFactor: 0.4, // Cover 40% of the available height
                      child: Card(
                        child: Column(
                          children: [
                            Expanded(
                              child: Image.network(
                                'https://via.placeholder.com/150',
                                fit: BoxFit.cover,
                              ),
                            ),
                            const Padding(
                              padding: EdgeInsets.all(8.0),
                              child: Text('Card 1 Text'),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),
                  Expanded(
                    child: FractionallySizedBox(
                      widthFactor: 0.8, // Cover 80% of the screen width
                      heightFactor: 0.4, // Cover 40% of the available height
                      child: Card(
                        child: Column(
                          children: [
                            Expanded(
                              child: Image.network(
                                'https://via.placeholder.com/150',
                                fit: BoxFit.cover,
                              ),
                            ),
                            const Padding(
                              padding: EdgeInsets.all(8.0),
                              child: Text('Card 2 Text'),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
