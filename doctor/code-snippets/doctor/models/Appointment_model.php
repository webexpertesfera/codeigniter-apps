<?php
class Appointment_model extends CI_Model {


    public function get_appointment($data) {

        $this->db->select("appoint.id,appoint.doctor_id,appoint.is_prescribe,appoint.patient_id,appoint.appointment_id,
        appoint.is_paid,appoint.date,appoint.serial_no,
        CONCAT(TIME_FORMAT(schedule.start_time,'%h:%i:%p'),'-',TIME_FORMAT(schedule.end_time,'%h:%i:%p')) as slot,
        CONCAT(patient.first_name,' ',patient.last_name) as patient_name,CONCAT(doctor.first_name,' ',doctor.last_name) as doctor_name")
            ->join("doct_schedule as schedule","schedule.id=appoint.schedule_id")
            ->join("hr_doctor as doctor","doctor.doctor_id=appoint.doctor_id")
            ->join("pat_patient as patient","appoint.patient_id=patient.patient_id")
            ->where(["appoint.doctor_id"=>$data['user_id'],"appoint.date"=>$data['date']]);

        $query = $this->db->get("doct_appointment as appoint");
        if($query->num_rows()>0) {

            return $query->result();
        }
        else {
            return [];
        }

    }


}