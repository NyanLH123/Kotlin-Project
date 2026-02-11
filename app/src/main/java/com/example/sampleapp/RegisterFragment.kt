package com.example.sampleapp

import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import com.android.volley.Request
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.example.sampleapp.databinding.FragmentRegisterBinding
import org.json.JSONObject

class RegisterFragment : Fragment() {
    private lateinit var binding: FragmentRegisterBinding
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        binding = FragmentRegisterBinding.inflate(layoutInflater, container, false)
        binding.btnRegister.setOnClickListener {
            val username = binding.editRegisUsername.text.toString()
            val email = binding.editRegisEmail.text.toString()
            val password = binding.editRegisPass.text.toString()
            val confirm = binding.editRegisConfirm.text.toString()

            if (password == confirm) {
                val user = User(0, username, email, password)

                Log.i("Register","***$username, $email, $password")
                registerUser(user)
            } else {
                Toast.makeText(context, "Password does not match", Toast.LENGTH_LONG).show()
            }


        }
        return binding.root
    }

    private fun registerUser(user: User) {
        val url = "http://10.0.2.2/projects/mobileapi/register.php"

        val request = object : StringRequest(Method.POST, url, { res ->
            Log.i("Register Listener", "***Successfully Register")
            val obj = JSONObject(res)

            val msg = obj.get("message").toString()

            Toast.makeText(context, "Response: $msg", Toast.LENGTH_LONG).show()
        }, {error->

            Log.i("Register Listener", "***Error Register:$error")
        }) {
            override fun getParams(): Map<String?, String?>? {
                return mapOf("username" to user.username, "email" to user.email, "password" to user.password)
            }
        }
        Volley.newRequestQueue(context).add(request)

    } //Register
} //RegisterFragment