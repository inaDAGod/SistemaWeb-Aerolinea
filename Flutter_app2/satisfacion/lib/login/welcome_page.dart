import 'package:flutter/material.dart';


class WelcomePage extends StatefulWidget {
  const WelcomePage({super.key});

  @override
  State<WelcomePage> createState() => _WelcomePageState();
}

class _WelcomePageState extends State<WelcomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFFFF4BA),
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                
                const Text(
                  'T R A S O',
                  style: TextStyle(
                    color: Color.fromARGB(255, 4, 4, 4),
                    fontSize: 60,
                    fontWeight: FontWeight.bold,
                    fontFamily: 'Times new roman',
                  ),
                ),
          
                const SizedBox(height: 25),
          
                Image.asset('lib/images/trasoIcon.png',
                height: 300,
               ),
          
                const SizedBox(height: 30),
          
               
                const SizedBox(height: 30),

                // sign up button
                
          
                const SizedBox(height: 30),
          
                
              ],
            ),
          ),
        ),
      ),
    );
  }
}