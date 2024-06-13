import 'package:flutter/material.dart';
import 'my_home_page.dart';

class SatisForm extends StatelessWidget {
  const SatisForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Formulario de Evaluación de Vuelo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSwatch(primarySwatch: Colors.lightBlue),
        
      ),
      home: const MyHomePage(title: ' '),
    );
  }
}
