import 'package:flutter/material.dart';
import 'task_list_screen.dart';

class MyHomePage extends StatefulWidget {
  const MyHomePage({Key? key}) : super(key: key);

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.end,
          children: [
            ElevatedButton(
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => TaskListScreen()),
                );
              },
              style: ElevatedButton.styleFrom(
                foregroundColor: Colors.white, backgroundColor: Colors.lightBlue, // Text color
              ),
              
              child: const Text('Calificar Vuelo', style: TextStyle(fontSize: 25)),
            ),
            const SizedBox(height: 16),
            Expanded(
              child: ListView(
                children: [
                  _buildArticleCard(
                    imageUrl: 'https://via.placeholder.com/150',
                    title: 'Descubre Nuevos Destinos',
                    summary: 'Explora emocionantes destinos de viaje alrededor del mundo.',
                  ),
                  const SizedBox(height: 16),
                  _buildArticleCard(
                    imageUrl: 'https://via.placeholder.com/150',
                    title: 'Consejos de Viaje para Principiantes',
                    summary: 'Consejos y trucos esenciales para viajeros primerizos.',
                  ),
                  const SizedBox(height: 16),
                  _buildArticleCard(
                    imageUrl: 'https://via.placeholder.com/150',
                    title: 'Top 10 Actividades de Aventura',
                    summary: 'Actividades de aventura emocionantes para los amantes de la adrenalina.',
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildArticleCard({required String imageUrl, required String title, required String summary}) {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              width: 100,
              height: 100,
              decoration: BoxDecoration(
                image: DecorationImage(
                  image: NetworkImage(imageUrl),
                  fit: BoxFit.cover,
                ),
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    summary,
                    style: const TextStyle(fontSize: 14),
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
