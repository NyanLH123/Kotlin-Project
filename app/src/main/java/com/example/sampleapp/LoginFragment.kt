package com.example.sampleapp

import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.sampleapp.databinding.FragmentLoginBinding
import org.json.JSONObject

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
                Log.i("Register","***$email, $password")
                loginUser(email, password)
            } else {
                Toast.makeText(context, "Login Failed", Toast.LENGTH_LONG).show()
            }
        }

        return binding.root
    }

    private fun loginUser(email: String, password: String) {
        val url = "http://10.0.2.2/projects/mobileapi/login.php"

        val request =  object: StringRequest(Method.POST, url, {
            res ->
            Log.d("Login Listener","***Login Successful: $res")

            val obj = JSONObject(res)
            val msg = obj.getString("message")

            val intent = Intent(context, UserActivity::class.java)


            Log.i("Login User", "***Hello, $email")
        }, {
            error ->
            Log.d("Login User", "***Login Error: $error")
        }) {
            override fun getParams(): Map<String?, String?>? {
                return mapOf("email" to email, "password" to password)
            }

        }
        Volley.newRequestQueue(context).add(request)
    }
}