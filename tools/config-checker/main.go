package main

import (
	"fmt"
	"os"
	"os/exec"
	"runtime"
	"strings"
)

const (
	colorReset  = "\033[0m"
	colorRed    = "\033[31m"
	colorGreen  = "\033[32m"
	colorYellow = "\033[33m"
	colorCyan   = "\033[36m"
	colorBold   = "\033[1m"
)

func main() {
	fmt.Println(colorCyan + "========================================" + colorReset)
	fmt.Println(colorCyan + "      WinAudit System Doctor 2026       " + colorReset)
	fmt.Println(colorCyan + "========================================" + colorReset)

	// 1. Check OS
	checkOS()

	// 2. Check PHP
	phpPath := checkPHP()

	// 3. Check PHP Config and Extensions
	missingExts := []string{}
	phpIniPath := ""
	if phpPath != "" {
		phpIniPath = checkPHPConfig(phpPath)
		missingExts = checkPHPExtensions(phpPath)
	}

	// 4. Check Project Files
	checkProjectFiles()

	// 5. Final Report & Fix Instructions
	if len(missingExts) > 0 {
		printFixInstructions(phpIniPath, missingExts)
	}

	fmt.Println("\nDoctor check complete.")
}

func checkOS() {
	fmt.Print("[OS] Checking operating system... ")
	if runtime.GOOS == "windows" {
		fmt.Println(colorGreen + "OK (Windows)" + colorReset)
	} else {
		fmt.Printf(colorYellow+"Warning: Target is %s. This project is optimized for Windows.\n"+colorReset, runtime.GOOS)
	}
}

func checkPHP() string {
	fmt.Print("[PHP] Checking for PHP in PATH... ")
	cmd := exec.Command("php", "-v")
	output, err := cmd.CombinedOutput()
	if err == nil {
		fmt.Printf(colorGreen+"OK (%s)\n"+colorReset, strings.Split(string(output), "\n")[0])
		return "php"
	}

	fmt.Println(colorYellow + "Not found in PATH." + colorReset)
	
	commonPaths := []string{
		`C:\xampp-8-1-25\php\php.exe`,
		`C:\xampp\php\php.exe`,
	}
	
	for _, path := range commonPaths {
		fmt.Printf("[PHP] Checking common path: %s... ", path)
		if _, err := os.Stat(path); err == nil {
			fmt.Println(colorGreen + "Found!" + colorReset)
			return path
		}
		fmt.Println(colorRed + "Not found." + colorReset)
	}
	return ""
}

func checkPHPConfig(phpPath string) string {
	fmt.Print("[PHP] Locating php.ini... ")
	cmd := exec.Command(phpPath, "--ini")
	output, err := cmd.CombinedOutput()
	if err == nil {
		lines := strings.Split(string(output), "\n")
		for _, line := range lines {
			if strings.Contains(line, "Loaded Configuration File:") {
				parts := strings.SplitN(line, ":", 2)
				if len(parts) < 2 {
					continue
				}
				path := strings.TrimSpace(parts[1])
				if path == "(none)" || path == "" {
					fmt.Println(colorRed + "NONE FOUND!" + colorReset)
					return ""
				} else {
					fmt.Println(colorGreen + path + colorReset)
					return path
				}
			}
		}
	}
	fmt.Println(colorRed + "Unknown" + colorReset)
	return ""
}

func checkPHPExtensions(phpPath string) []string {
	extensions := []string{"sqlite3", "pdo_sqlite", "mysqli", "intl", "mbstring", "curl"}
	missing := []string{}
	fmt.Println("[PHP] Checking required extensions:")
	for _, ext := range extensions {
		fmt.Printf("  - %-12s: ", ext)
		cmd := exec.Command(phpPath, "-m")
		output, _ := cmd.CombinedOutput()
		if strings.Contains(strings.ToLower(string(output)), ext) {
			fmt.Println(colorGreen + "OK" + colorReset)
		} else {
			fmt.Println(colorRed + "MISSING!" + colorReset)
			missing = append(missing, ext)
		}
	}
	return missing
}

func printFixInstructions(phpIniPath string, missing []string) {
	fmt.Println(colorRed + colorBold + "\n!!! CRITICAL ACTION REQUIRED !!!" + colorReset)
	fmt.Printf("The following PHP extensions are missing: %s\n", strings.Join(missing, ", "))
	
	if phpIniPath != "" {
		fmt.Println(colorYellow + "\nTO FIX THIS:" + colorReset)
		fmt.Printf("1. Open this file: %s\n", phpIniPath)
		fmt.Println("2. Search for (Ctrl+F) the following lines:")
		for _, ext := range missing {
			fmt.Printf("   ;extension=%s\n", ext)
		}
		fmt.Println("3. Remove the semicolon (;) from the start of those lines.")
		fmt.Println("4. Save the file and restart your Web Server / Apache.")
	} else {
		fmt.Println(colorRed + "Could not locate php.ini to provide automated instructions." + colorReset)
	}
}

func checkProjectFiles() {
	fmt.Println("[Project] Checking files:")
	files := []struct {
		path string
		hint string
	}{
		{"win-audit-dashboard/.env", "Rename .env_sqlite to .env"},
		{"win-audit-dashboard/writable/database.sqlite", "Run 'php spark migrate'"},
		{"composer.phar", "Download composer.phar to project root"},
	}

	for _, f := range files {
		fmt.Printf("  - %-45s: ", f.path)
		if _, err := os.Stat("../../" + f.path); err == nil {
			fmt.Println(colorGreen + "OK" + colorReset)
		} else {
			fmt.Println(colorRed + "MISSING!" + colorReset)
			fmt.Printf(colorYellow+"    -> Action: %s\n"+colorReset, f.hint)
		}
	}
	
	fmt.Print("  - win-audit-dashboard/writable                 : ")
	info, err := os.Stat("../../win-audit-dashboard/writable")
	if err == nil && info.IsDir() {
		fmt.Println(colorGreen + "OK" + colorReset)
	} else {
		fmt.Println(colorRed + "MISSING or NOT A DIRECTORY!" + colorReset)
	}
}
