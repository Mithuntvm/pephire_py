call "C:\ProgramData\Anaconda3\Scripts\activate.bat"
cd "C:\Pephire\Weekly Jobs\IT"
python JobsByLocation_V15.py
python BatchJob_v1.py
"C:\Program Files\R\R-4.1.0\bin\Rscript.exe" "C:\Pephire\Weekly Jobs\IT\PephireStaticTables_V4.R"
