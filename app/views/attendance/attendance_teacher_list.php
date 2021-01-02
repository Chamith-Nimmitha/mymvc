<div id="content" class="col-11 col-md-8 col-lg-9 flex-col align-items-center justify-content-start">
    <div id="attendance_notification" class="d-none w-75">
        <p style="background: #eee;" class="w-100 p-2 text-center fg-red"> </p>
    </div>
	<div class="col-12 flex-col">
        <div class="d-flex justify-content-center align-items-center">
            <form  id="attendance_filter" class="d-flex align-items-center col-12">
                <div class="d-flex col-12 align-items-center justify-content-center">
                    <div class="mt-5">
                        <input type="reset" class="btn btn-blue" onclick="reset_form(this)" value="reset">
                    </div>
                    <div class="ml-5">
                        <label for="teacher-id">Teacher ID/Name</label>
                        <input type="text" name="teacher-id" id="teacher-id" placeholder="Teacher ID/Name" oninput="teacher_attendance_search()" value="">
                    </div>
                    <div class="ml-5 d-flex flex-col">
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" placeholder="Student ID" value="<?php  if(isset($date)){echo $date;}else{echo date('Y-m-d');} ?>">
                    </div>
                    <input type="submit" onclick="teacher_attendance_search()" class="btn btn-blue ml-3 mt-5" value="Filter">
                </div>
            </form>
        </div>

        <form id="mark_teacher_attendance" method="POST" class="col-12">
            <div class="col-12 flex-col" style="overflow-x: scroll;overflow-y: hidden;">
                <input type="hidden" name="date_hidden" id="date_hidden" value="<?php if(isset($date)){echo $date;}else{echo date("Y-m-d");} ?>">
                <input type="radio" name="radio_hidden" id="radio_hidden" value="<?php if(isset($date)){echo $date;}else{echo date("Y-m-d");} ?>">
    		    <table class="table-strip-dark text-center">
    			    <caption class="p-5"><b>Teachers Attendance<br/><span id="attendance_date"><?php if(isset($date)){echo $date;}else{echo date("Y-m-d");} ?></span></b></caption>
    			    <thead>
    				    <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>DATE</th>
                            <th>NAME</th>
                            <th>ATTENDANCE</th>
                            <th>NOTE</th>
                            <th>VIEW ATTENDANCE</th>
    				    </tr>
    			    </thead>  
                    <tbody id="tbody">
                        <?php 
                            if($teacher_list && !empty($teacher_list)){
                             for($i=0; $i<count($teacher_list); $i++){
                         ?>
                        <tr>
                            <td class="text-center"><?php echo $i+1; ?></td>
                            <td><?php echo $teacher_list[$i]['id']; ?></td>
                            <td><?php echo $teacher_list[$i]['name_with_initials']; ?></td>
                            <td><?php if(isset($teacher_list[$i]['date'])){echo $teacher_list[$i]['date'];}else{echo date("Y-m-d");} ?></td>
                            <td class="d-flex flex-col">
                                 <label for="present-<?php echo $teacher_list[$i]['id']; ?>">
                                    <input type="radio" id="present-<?php echo $teacher_list[$i]['id']; ?>" name="attendance-<?php echo $teacher_list[$i]['id']; ?>" value="1" <?php if(isset($teacher_list[$i]['attendance']) && $teacher_list[$i]['attendance'] == 1){echo " checked='checked'";} ?> > Present
                                </label>
                                <label for="absent-<?php echo $teacher_list[$i]['id']; ?>">
                                    <input type="radio" id="absent-<?php echo $teacher_list[$i]['id']; ?>" name="attendance-<?php echo $teacher_list[$i]['id']; ?>" value="0" <?php if(isset($teacher_list[$i]['attendance']) && $teacher_list[$i]['attendance'] == 0){echo " checked='checked'";} ?> > Absent
                                </label>
                            </td>
                            <td><input type="text" name="note-<?php echo $teacher_list[$i]['id']; ?>" value="<?php if(isset($teacher_list[$i]['note'])) {echo $teacher_list[$i]['note'];} ?>"></td>
                            <td> <a href="<?php echo set_url("teacher/attendance/".$teacher[$i]['id']) ?>" class="btn btn-blue">View Report</a></td>

                        </tr>
                        <?php 
                                }
                            }else{
                                echo "<tr><td colspan=7 class='text-center bg-red'>Teachers not found...</td></tr>";
                            } 
                        ?>
                    </tbody>
                </table>
                <div class="w-100 p-1"></div>

    		</div>  
                <div class="form-group d-flex flex-row w-90 justify-content-end">
    		        <button type="submit" name="submit" onclick="mark_teacher_attendance()" class="btn btn-blue m-1">Mark Attendance</button>
                </div>
        </form>
    </div>
</div>