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
            const Text('Formulario Realizado'),
          ],
        ),
        automaticallyImplyLeading: false,
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
