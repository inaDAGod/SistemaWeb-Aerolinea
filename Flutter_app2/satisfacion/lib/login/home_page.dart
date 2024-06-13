import 'package:flutter/material.dart';
import 'package:firebase_auth/firebase_auth.dart';

import 'auth_services.dart';
class HomePage extends StatelessWidget {
  HomePage({super.key});
  final user = FirebaseAuth.instance.currentUser!;
 
  @override
  Widget build(BuildContext context) {
  return Scaffold(
    appBar: AppBar(
      actions: [
        IconButton(
          onPressed: () async {
            await AuthServices.signUserOut();
          },
          icon: const Icon(Icons.logout),
        ),
      ],
    ),
    body: Center(
      child: Text("Logged in as: ${user.email ?? "Unknown"}"),
    ),
  );
  }
  }