package main

import (
	"encoding/json"
	"fmt"
	"log"
	"os"
	"os/exec"
	"runtime"
	"strings"
	"time"
)

// AuditData represents the full system audit result
type AuditData struct {
	Timestamp      string            `json:"timestamp"`
	Hostname       string            `json:"hostname"`
	OSInfo         OSInfo            `json:"os_info"`
	HardwareInfo   HardwareInfo      `json:"hardware_info"`
	NetworkInfo    []NetworkInterface `json:"network_info"`
	SecurityInfo   SecurityInfo      `json:"security_info"`
	SystemUpdates  []string          `json:"system_updates"`
}

type OSInfo struct {
	Name         string `json:"name"`
	Version      string `json:"version"`
	Architecture string `json:"architecture"`
}

type HardwareInfo struct {
	CPU          string      `json:"cpu"`
	RAMTotal     string      `json:"ram_total"`
	DiskPartitions []DiskInfo `json:"disk_partitions"`
}

type DiskInfo struct {
	Device      string `json:"device"`
	TotalSizeGB float64 `json:"total_size_gb"`
	FreeSpaceGB float64 `json:"free_space_gb"`
}

type NetworkInterface struct {
	Name string   `json:"name"`
	IPs  []string `json:"ips"`
	MAC  string   `json:"mac"`
}

type SecurityInfo struct {
	AVStatus      string `json:"av_status"`
	FirewallStatus string `json:"firewall_status"`
}

func main() {
	hostname, _ := os.Hostname()
	data := AuditData{
		Timestamp: time.Now().Format(time.RFC3339),
		Hostname:  hostname,
	}

	// 1. Gather OS Info
	data.OSInfo = getOSInfo()

	// 2. Gather Hardware Info
	data.HardwareInfo = getHardwareInfo()

	// 3. Gather Network Info
	data.NetworkInfo = getNetworkInfo()

	// 4. Gather Security Info
	data.SecurityInfo = getSecurityInfo()

	// 5. Gather Hotfixes
	data.SystemUpdates = getHotfixes()

	// Export to JSON
	fileName := fmt.Sprintf("audit_%s_%d.json", hostname, time.Now().Unix())
	file, err := os.Create(fileName)
	if err != nil {
		log.Fatalf("Failed to create file: %v", err)
	}
	defer file.Close()

	encoder := json.NewEncoder(file)
	encoder.SetIndent("", "  ")
	if err := encoder.Encode(data); err != nil {
		log.Fatalf("Failed to encode JSON: %v", err)
	}

	fmt.Printf("Audit completed successfully. Results saved to: %s\n", fileName)
}

func runPowerShell(command string) string {
	cmd := exec.Command("powershell", "-NoProfile", "-Command", command)
	output, err := cmd.CombinedOutput()
	if err != nil {
		return fmt.Sprintf("Error: %v", err)
	}
	return strings.TrimSpace(string(output))
}

func getOSInfo() OSInfo {
	name := runPowerShell("(Get-WmiObject Win32_OperatingSystem).Caption")
	version := runPowerShell("(Get-WmiObject Win32_OperatingSystem).Version")
	return OSInfo{
		Name:         name,
		Version:      version,
		Architecture: runtime.GOARCH,
	}
}

func getHardwareInfo() HardwareInfo {
	cpu := runPowerShell("(Get-WmiObject Win32_Processor).Name")
	ramTotal := runPowerShell("[math]::round((Get-WmiObject Win32_ComputerSystem).TotalPhysicalMemory / 1GB, 2).ToString() + ' GB'")
	
	// Get Disk info via PowerShell for simplicity
	diskRaw := runPowerShell("Get-WmiObject Win32_LogicalDisk -Filter 'DriveType=3' | ForEach-Object { \"$($_.DeviceID)|$($_.Size)|$($_.FreeSpace)\" }")
	disks := []DiskInfo{}
	lines := strings.Split(diskRaw, "\n")
	for _, line := range lines {
		parts := strings.Split(strings.TrimSpace(line), "|")
		if len(parts) == 3 {
			sizeGB := parseFloat(parts[1]) / (1024 * 1024 * 1024)
			freeGB := parseFloat(parts[2]) / (1024 * 1024 * 1024)
			disks = append(disks, DiskInfo{
				Device:      parts[0],
				TotalSizeGB: sizeGB,
				FreeSpaceGB: freeGB,
			})
		}
	}

	return HardwareInfo{
		CPU:            cpu,
		RAMTotal:       ramTotal,
		DiskPartitions: disks,
	}
}

func getNetworkInfo() []NetworkInterface {
	// Simplified network info
	interfaces := []NetworkInterface{}
	raw := runPowerShell("Get-NetIPAddress -AddressFamily IPv4 | ForEach-Object { \"$($_.InterfaceAlias)|$($_.IPAddress)\" }")
	lines := strings.Split(raw, "\n")
	for _, line := range lines {
		parts := strings.Split(strings.TrimSpace(line), "|")
		if len(parts) == 2 {
			interfaces = append(interfaces, NetworkInterface{
				Name: parts[0],
				IPs:  []string{parts[1]},
			})
		}
	}
	return interfaces
}

func getSecurityInfo() SecurityInfo {
	av := runPowerShell("Get-WmiObject -Namespace root/SecurityCenter2 -Class AntiVirusProduct | ForEach-Object { $_.displayName }")
	if av == "" { av = "Not Found" }
	fw := runPowerShell("netsh advfirewall show allprofiles state | Select-String 'State'")
	return SecurityInfo{
		AVStatus:       av,
		FirewallStatus: fw,
	}
}

func getHotfixes() []string {
	raw := runPowerShell("Get-HotFix | Select-Object -First 10 -Property HotFixID | ForEach-Object { $_.HotFixID }")
	if raw == "" { return []string{} }
	return strings.Split(raw, "\n")
}

func parseFloat(s string) float64 {
	var f float64
	fmt.Sscanf(s, "%f", &f)
	return f
}
