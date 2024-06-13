import 'package:flutter/material.dart';

import 'auth_services.dart';
import 'loginComponents/my_button.dart';
import 'loginComponents/my_textfield.dart';


class RegisterPage extends StatefulWidget {
  final Function()? onTap;
  const RegisterPage({super.key, required this.onTap});

  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  // text editing controllers
  final emailController = TextEditingController();

  final passwordController = TextEditingController();

  final confirmpasswordController = TextEditingController();




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
          
               Image.asset('lib/images/medusa.webp',
               ),
          
                const SizedBox(height: 30),
          
                // welcome back, you've been missed!
                const Text(
                  'Bienvenidx a Traso!',
                  style: TextStyle(
                    color: Color.fromARGB(255, 4, 4, 4),
                    fontSize: 30,
                    fontWeight: FontWeight.bold,
                    fontFamily: 'Times new roman',
                  ),
                ),
          
                const SizedBox(height: 25),
          
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
                 // confirm password textfield
                MyTextField(
                  controller: confirmpasswordController,
                  hintText: 'Confirma tu contraseña',
                  obscureText: true,
                ),
          
                const SizedBox(height: 25),
                
          
                // sign in button
                MyButton(
                   onTap: () => AuthServices.signUserUp(emailController.text, passwordController.text, confirmpasswordController.text, context),
                  buttonText: 'Registrarse',
                  buttonColor: const Color(0xFF769EBB),
                ),
          
                const SizedBox(height: 30),
          
                // not a member? register now
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(
                      'Ya estas registradx?',
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
                        'Iniciar Sesión',
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