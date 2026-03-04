package com.example.sampleapp

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import com.example.sampleapp.databinding.FragmentEntryBinding

class EntryFragment : Fragment() {
    private lateinit var binding: FragmentEntryBinding
  private val activityList = listOf("Select one of the Activity: Running , Cycling, Boxing, WeightLifting, Dancing, Yoga")
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {

        binding = FragmentEntryBinding.inflate(inflater, container, false)
        val spinnerAdapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_item, activityList)
        spinnerAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        return binding.root
    }


}