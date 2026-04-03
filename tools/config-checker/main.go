package main

import (
	"fmt"
	"os"
	"os/exec"
	"runtime"
	"strings"
)

func main() {
	fmt.Println("========================================")
	fmt.Println("      WinAudit System Doctor 2026       ")
	fmt.Println("========================================")

	// 1. Check OS
	checkOS()

	// 2. Check PHP
	phpPath := checkPHP()

	// 3. Check PHP Extensions
	if phpPath != "" {
		checkPHPExtensions(phpPath)
	}

	// 4. Check Project Files
	checkProjectFiles()

	fmt.Println("\nDoctor check complete.")
}

func checkOS() {
	fmt.Print("[OS] Checking operating system... ")
	if runtime.GOOS == "windows" {
		fmt.Println("OK (Windows)")
	} else {
		fmt.Printf("Warning: Target is %s. This project is optimized for Windows.\n", runtime.GOOS)
	}
}

func checkPHP() string {
	fmt.Print("[PHP] Checking for PHP in PATH... ")
	cmd := exec.Command("php", "-v")
	output, err := cmd.CombinedOutput()
	if err == nil {
		fmt.Printf("OK (%s)\n", strings.Split(string(output), "\n")[0])
		return "php"
	}

	fmt.Println("Not found in PATH.")
	
	// Try common XAMPP paths
	commonPaths := []string{
		`C:\xampp-8-1-25\php\php.exe`,
		`C:\xampp\php\php.exe`,
	}
	
	for _, path := range commonPaths {
		fmt.Printf("[PHP] Checking common path: %s... ", path)
		if _, err := os.Stat(path); err == nil {
			fmt.Println("Found!")
			return path
		}
		fmt.Println("Not found.")
	}
	return ""
}

func checkPHPExtensions(phpPath string) {
	extensions := []string{"sqlite3", "mysqli", "intl", "mbstring", "curl"}
	fmt.Println("[PHP] Checking required extensions:")
	for _, ext := range extensions {
		fmt.Printf("  - %s: ", ext)
		cmd := exec.Command(phpPath, "-m")
		output, _ := cmd.CombinedOutput()
		if strings.Contains(strings.ToLower(string(output)), ext) {
			fmt.Println("OK")
		} else {
			fmt.Println("MISSING!")
			fmt.Printf("    -> Hint: Enable 'extension=%s' in your php.ini\n", ext)
		}
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
		fmt.Printf("  - %s: ", f.path)
		if _, err := os.Stat("../../" + f.path); err == nil {
			fmt.Println("OK")
		} else {
			fmt.Println("MISSING!")
			fmt.Printf("    -> Action: %s\n", f.hint)
		}
	}
	
	// Check writable folder permissions
	fmt.Print("  - win-audit-dashboard/writable: ")
	info, err := os.Stat("../../win-audit-dashboard/writable")
	if err == nil && info.IsDir() {
		fmt.Println("OK")
	} else {
		fmt.Println("MISSING or NOT A DIRECTORY!")
	}
}
