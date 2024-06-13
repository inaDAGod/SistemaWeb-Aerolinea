import 'package:flutter/material.dart';

class ConfirmationPage extends StatelessWidget {
  const ConfirmationPage({Key? key}) : super(key: key);

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
            const Text('Formulario Realizado', style: TextStyle(color: Colors.white)),
          ],
        ),
        automaticallyImplyLeading: false,
      ),
      body: Center(
        child: const Text(
          '¡Gracias por enviar el formulario!',
          style: TextStyle(fontSize: 30, color: Colors.white),
        ),
      ),
    );
  }
}
