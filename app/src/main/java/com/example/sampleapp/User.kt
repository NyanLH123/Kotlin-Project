package com.example.sampleapp
import java.io.Serializable

data class User(val id:Int,
                val username: String,
                val email: String,
                val password: String): Serializable
