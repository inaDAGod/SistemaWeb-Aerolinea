import 'package:flutter/material.dart';
import 'auth_services.dart';
import 'loginComponents/my_button.dart';
import 'loginComponents/my_textfield.dart';


class LoginPage extends StatefulWidget {
  final Function()? onTap;
  const LoginPage({super.key, required this.onTap});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  // text editing controllers
  final emailController = TextEditingController();
  final passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFD6D7FE),
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
          
                // username textfield
                MyTextField(
                  controller: emailController,
                  hintText: 'Correo electronico',
                  obscureText: false,
                ),
          
                const SizedBox(height: 15),
          
                // password textfield
                MyTextField(
                  controller: passwordController,
                  hintText: 'Contraseña',
                  obscureText: true,
                ),
          
                const SizedBox(height: 25),
          
                
          
                // sign in button
                MyButton(
                  onTap: () => AuthServices.signUserIn(emailController.text, passwordController.text, context),
                  buttonText: 'Iniciar Sesión',
                  buttonColor: const Color(0xFF769EBB),
                ),
          
                const SizedBox(height: 30),
          
                // not a member? register now
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(
                      'No estas registradx?',
                      style: TextStyle(color: Colors.grey[700]),
                    ),
                    
                    
                  ],
                ),
                const SizedBox(height: 4),
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    GestureDetector(
                      onTap: widget.onTap,
                      child: const Text(
                        'Registrate ahora',
                        style: TextStyle(
                          color: Colors.blue,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ],
                )
              ],
            ),
          ),
        ),
      ),
    );
  }
}