import 'package:firebase_auth/firebase_auth.dart';
import 'package:flutter/material.dart';

class AuthServices  {

  static Future<void> signUserIn(String email, String password, BuildContext context) async {
    // show loading circle
    showDialog(
      context: context,
      builder: (context) {
        return const Center(
          child: CircularProgressIndicator(),
        );
      },
    );

    // try sign in
    try {
      await FirebaseAuth.instance.signInWithEmailAndPassword(
        email: email,
        password: password,
      );
      // pop the loading circle
      // ignore: use_build_context_synchronously
      Navigator.pop(context);
    } on FirebaseAuthException catch (e) {
      // pop the loading circle
      Navigator.pop(context);
      if(e.code == 'user-not-found'){
        wrongMessage('Usuario no encontrado', context);
      }
      else{
        if(e.code == 'wrong-password'){
           wrongMessage('Contraseña equivocada', context);
        }
        else{
          if(e.code == 'invalid-credential'){
            wrongMessage('Parece que algo salio mal', context);
          }
          else{
             wrongMessage(e.code, context);
          }
          
        }
      }
     
    }
  }
  static void wrongMessage(String mensaje, BuildContext context){
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          backgroundColor: const Color(0xFF9A9DED),
          title: Center(
            child: Text(
              mensaje,
              style: const TextStyle(color: Colors.white),
            ),
          ),
        );
      },
    );
  }


  static Future<void> signUserUp(String email, String password,String confirmPassword, BuildContext context) async {
    // show loading circle
    showDialog(
      context: context,
      builder: (context) {
        return const Center(
          child: CircularProgressIndicator(),
        );
      },
    );

    // try sign in
    try {
      if(password == confirmPassword){
        await FirebaseAuth.instance.createUserWithEmailAndPassword(
          email: email,
          password: password,
        );
         // ignore: use_build_context_synchronously
         Navigator.pop(context);
      }else{
        Navigator.pop(context);
        wrongMessage('No coinciden las contraseñas', context);
      }
     
    } on FirebaseAuthException catch (e) {
      // pop the loading circle
      Navigator.pop(context);
      wrongMessage(e.code, context);

     
    }
  }
  static Future<void> signUserOut()async{
    FirebaseAuth.instance.signOut();
  }
}