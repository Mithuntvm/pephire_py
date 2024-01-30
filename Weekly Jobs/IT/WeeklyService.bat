call "C:\ProgramData\Anaconda3\Scripts\activate.bat"
cd "C:\Pephire\Weekly Jobs\IT"
python JobsByLocation_V16.py
python BatchJob_v2.py
"C:\Program Files\R\R-4.1.0\bin\Rscript.exe" "C:\Pephire\Weekly Jobs\IT\WeeklyJobs.R"

