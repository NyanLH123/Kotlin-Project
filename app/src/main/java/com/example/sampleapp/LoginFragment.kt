package com.example.sampleapp

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import com.example.sampleapp.databinding.FragmentLoginBinding

class LoginFragment : Fragment() {
    private lateinit var binding: FragmentLoginBinding
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding= FragmentLoginBinding.inflate(layoutInflater, container, false)
        binding.btnLogin.setOnClickListener {
            val email = binding.editLoginEmail.text.toString()
            val password = binding.editLoginPassword.text.toString()

            if (email == "nyan@gmail.com" && password =="12345") {
                Toast.makeText(context, "Login Successful", Toast.LENGTH_LONG).show()
            } else {
                Toast.makeText(context, "Login Failed", Toast.LENGTH_LONG).show()
            }
        }
        binding.btnLoginGoogle.setOnClickListener {

        }

        return binding.root
    }
}