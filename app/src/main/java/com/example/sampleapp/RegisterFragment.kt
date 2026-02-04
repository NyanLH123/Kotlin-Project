package com.example.sampleapp

import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import com.example.sampleapp.databinding.FragmentRegisterBinding

class RegisterFragment : Fragment() {
    private lateinit var binding: FragmentRegisterBinding
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentRegisterBinding.inflate(layoutInflater, container, false)
        binding.btnRegister.setOnClickListener {
            val email = binding.editRegisEmail.text.toString()
            val password = binding.editRegisPass.text.toString()
            val confirm = binding.editRegisConfirm.text.toString()

            Log.i("Register","***$email, $password, $confirm")
        }
        return binding.root
    }
}