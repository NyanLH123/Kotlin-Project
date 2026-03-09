package com.example.sampleapp

import android.app.DatePickerDialog
import android.app.TimePickerDialog
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ArrayAdapter
import androidx.compose.material3.DatePickerDialog
import com.example.sampleapp.databinding.FragmentEntryBinding
import java.text.SimpleDateFormat
import java.util.Calendar
import java.util.Locale

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

        val calendar= Calendar.getInstance()
        binding.editDate.setOnClickListener {

            val datePickerDialog= DatePickerDialog(requireContext(),
                {_, y,m,d ->
                    val cal = Calendar.getInstance()
                    cal.set(y, m, d)

                    val dateFormat = SimpleDateFormat("dd/MM/yyyy", Locale.getDefault())
                    val selectedDate = dateFormat.format(cal.time)
                    binding.editDate.text = selectedDate
                },
                calendar.get(Calendar.YEAR),
                calendar.get(Calendar.MONTH),
                calendar.get(Calendar.DAY_OF_MONTH)
                )
        }

        binding.editTime.setOnClickListener {

            val timePickerDialog = TimePickerDialog(requireContext(),
                {_, hr,min ->
                    val cal = Calendar.getInstance()
                    cal.set(Calendar.HOUR_OF_DAY, hr)
                    cal.set(Calendar.MINUTE, min)


                    val timeFormat = SimpleDateFormat("hh:mm a", Locale.getDefault())
                    val selectedTime = timeFormat.format(cal.time)
                    binding.editTime.text = selectedTime
                },
                calendar.get(Calendar.HOUR_OF_DAY),
                calendar.get(Calendar.MINUTE),
                false
            )

            timePickerDialog.show()
        }

        return binding.root
    }


}