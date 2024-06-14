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
          crossAxisAlignment: CrossAxisAlignment.start, // Cambiado a start para alinear la imagen y el texto al inicio
          children: [
            // Imagen y Texto Añadidos
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Image.asset(
                  'assets/logoavion.png', // Ruta de la imagen en assets
                  width: double.infinity,
                  height: 280,
                  fit: BoxFit.cover,
                ),
                const SizedBox(height: 16),
                
                const SizedBox(height: 8),
                const Text(
                  'Explora destinos, califica tus vuelos y mucho más.',
                  style: TextStyle(
                    fontSize: 16,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 32), // Espacio entre el bloque de imagen/texto y el botón

            // Botón para navegar a la pantalla de tareas
            Center(
              child: ElevatedButton(
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
            ),
            const SizedBox(height: 16),
const SizedBox(height: 16),

            // Título de la Sección de Artículos
            const Divider(
              color: Colors.grey, // Color del Divider
              thickness: 2, // Grosor del Divider
              height: 20, // Espacio entre el Divider y los elementos adyacentes
            ),
            const Center(
              child: Text(
                'Artículos Destacados',
                style: TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: Colors.indigo, // Color azul marino
                ),
              ),
            ),
            
            
            // Lista de Artículos
            Expanded(
              child: ListView(
                children: [
                  
                  _buildArticleCard(
                    imageUrl: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/La_Paz_Skyline.jpg/288px-La_Paz_Skyline.jpg',
                    title: 'Descubre Nuevos Destinos',
                    summary: 'Explora emocionantes destinos de viaje alrededor de Bolivia.',
                  ),
                  const SizedBox(height: 16),
                  _buildArticleCard(
                    imageUrl: 'https://www.caminitoamor.com/wp-content/uploads/2020/01/Consejos-para-Viajeros-Principiantes.jpg',
                    title: 'Consejos de Viaje para Principiantes',
                    summary: 'Consejos y trucos esenciales para viajeros primerizos.',
                  ),
                  const SizedBox(height: 16),
                  _buildArticleCard(
                    imageUrl: 'https://www.lostiempos.com/sites/default/files/styles/noticia_detalle/public/media_imagen/2023/6/5/camino_de_la_muerte_-_expeditionearth.live_.jpg?itok=G9oghhCS',
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

  // Función para construir las tarjetas de los artículos
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