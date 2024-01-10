<?php

namespace App\Models\Location\Traits\Attribute;

trait RegionAttribute {

    /**
     * @return string
     */


//     public function employerCount()
//     {
//         $count = $this->employers()->select(['id'])->count();
//         return $count;
//     }


//     public function unregisteredEmployerCount()
//     {
//         $count = $this->unregisteredEmployers()->select(['id'])->count();
//         return $count;
//     }

//     /* Percentage ratio of registered to unregistered*/
//     public function employerRegisteredUnregisteredPercentage()
//     {
//         $registered = $this->employerCount();
//         $total = $this->unregisteredEmployerCount() + $this->employerCount();
//         $percentage =  ($total > 0)  ?  (($registered * 100) / ($total)) : 0;
//         return $percentage;
//     }

//     /*Employer Registration certificate issued per region */
//     public function employerCertificateIssued()
//     {
//         $count = $this->employers()->whereHas('employerCertificateIssues', function ($query){
//             $query->where('is_reissue', 0);
//         })->count();
//         return $count;
//     }

// /* Issued certificate against employer registered (%)*/
//     public function employerCertificateIssuedPercentage()
//     {
//         $employer_registered = $this->employerCount();
//         $certificate_issued = $this->employerCertificateIssued();
//        $percentage = ($employer_registered > 0) ? (($certificate_issued * 100) / $employer_registered) : 0;
//        return $percentage;
//     }


}
