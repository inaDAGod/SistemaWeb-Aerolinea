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
      body: Center( // Center widget added here
        child: Padding(
          padding: EdgeInsets.all(MediaQuery.of(context).size.width * 0.02),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Text(
                'Cuentanos de su viaje',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 28,
                ),
              ),
              const SizedBox(height: 30),
              ElevatedButton(
                onPressed: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (context) => TaskListScreen()),
                  );
                },
                child: const Text('Ir a la Formulario', style: TextStyle(fontSize: 25)),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
