 <div class="row mt-12" style="margin-bottom:12px;">
                            <div class="col-md-12 mx-auto" style="padding: 0px 11px;margin-left: -1px;">
                                <div class="input-group" style="margin-top: 10px;">
                                    <input class="form-control border-end-0 border" type="search" id="example-search-input" placeholder="Search job description" onkeyup="mysearchFunction()">
                                    <span class="input-group-append">

                                    </span>
                                </div>
                            </div>
                        </div>

                        @if(!$jobs->isEmpty())
                        @foreach($jobs as $single_job)
                        <?php

                        $count = App\Candidate_Jobs::where('job_id', $single_job->id)->where('shortlist', '1')->count();
                        $acc = DB::connection('pephire')
                            ->table('candidate__jobs')
                            ->join('jobs', 'candidate__jobs.job_id', '=', 'jobs.id')
                            ->join('candidates', 'candidate__jobs.candidate_id', '=', 'candidates.id')
                            ->join('configurable_candidatestages', 'configurable_candidatestages.candidate_id', '=', 'candidates.id')
                            ->where('candidates.organization_id', auth()->user()->organization_id)
                            ->where('candidate__jobs.job_id', $single_job->id)
                            ->where(function ($query) {
                                $query->whereNotNull('configurable_candidatestages.stage')
                                    ->where('configurable_candidatestages.stage', '!=', 'sourced');
                            })
                            ->distinct()
                            ->count();
                        $not = $count - $acc;
                        if ($count > 0) {
                        ?>
                            <div class="card" style="padding: 5px;" onclick="jobselect(this);" id="jobcard_{{$single_job->id}}" jobid="<?php echo $single_job->id; ?>" jd="<?php echo $single_job->description; ?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h6 class="job_title ">{{ucwords($single_job->job_role)}}</h6>
                                        <small>Experience : {{$single_job->min_experience}}-{{$single_job->max_experience}} years</small>
                                        <br>
                                        <small class="job_id" style="display: none;">{{$single_job->id}}</small>
                                        <small>
                                            <table style="width: 100%;">
                                                <tbody>
                                                    <tr>

                                                        <td><span class="dot dot-orange"></span>&nbsp;{{$count}}</td>
                                                        <td><span class="dot dot-green"></span>&nbsp;{{$acc}}</td>

                                                        <td><span class="dot dot-blue"></span>&nbsp;{{$not}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </small>
                                    </div>
                                    <?php
                                    $contacted = $count;
                                    $accepted = $acc;
                                    $percentage = ($accepted / $contacted) * 100;
                                    $roundedPercentage = round($percentage, 0);
                                    ?>
                                    <div class="col-lg-4">
                                        <span class="percentage-span">{{$roundedPercentage}}%</span>
                                        <i class="fa fa-remove delete-icon" onclick="openDeleteConfirmationModal(<?php echo $single_job->id; ?>)" style="cursor: pointer;"></i>
                                    </div>


                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        @endforeach
                        @endif